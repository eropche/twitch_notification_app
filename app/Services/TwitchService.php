<?php
declare(strict_types = 1);

namespace App\Services;

use App\BannedUsersCount;
use App\Broadcaster;
use App\Category;
use App\InterestBroadcaster;
use App\StreamHistory;
use App\SubsCount;
use App\Telegram\TwitchBotSender;
use App\TwitchApi\Authorization;
use App\TwitchApi\Broadcaster as BroadcasterApi;
use App\TwitchApi\Category as CategoryApi;
use App\TwitchApi\Clip;
use App\TwitchApi\Configuration;
use App\TwitchApi\Stream;
use DateTimeImmutable;

class TwitchService
{
    protected $authorizationApi;
    protected $broadcasterApi;
    protected $categoryApi;
    protected $streamApi;
    protected $clipApi;
    protected $botSender;

    public function __construct(
        Authorization $authorizationApi,
        BroadcasterApi $broadcasterApi,
        CategoryApi $categoryApi,
        Stream $streamApi,
        Clip $clipApi,
        TwitchBotSender $botSender
    ) {
        $this->authorizationApi = $authorizationApi;
        $this->broadcasterApi   = $broadcasterApi;
        $this->categoryApi      = $categoryApi;
        $this->streamApi        = $streamApi;
        $this->clipApi          = $clipApi;
        $this->botSender        = $botSender;
    }

    public function broadcastersActualize()
    {
        if (!Configuration::authorizationToken()) {
            $this->authorizationApi->token();
        }

        $interestBroadcasters = InterestBroadcaster::all();
        foreach ($interestBroadcasters as $interestBroadcaster) {
            if (Broadcaster::where('name', $interestBroadcaster->name)->first()) {
                continue;
            }
            $responseBroadcaster = $this->broadcasterApi->getBroadcastersByName($interestBroadcaster->name);

            Broadcaster::create([
                'name'        => $responseBroadcaster['display_name'],
                'twitch_id'   => $responseBroadcaster['id'],
                'description' => $this->broadcasterApi->getChannelDescription($responseBroadcaster['id']),
            ]);

            $this->categorySave($responseBroadcaster['game_id']);
        }

    }

    public function checkLiveStreamStatus()
    {
        foreach (Broadcaster::where('is_live', true)->get() as $broadcaster) {
            $stream        = $this->streamApi->getStream($broadcaster->twitch_id);
            $streamHistory = StreamHistory::where('broadcaster_id', $broadcaster->id)
                ->orderBy('created_at', 'desc')
                ->first();
            if (!$stream || $stream['type'] !== 'live') {

                $this->botSender->endStreamNotification($broadcaster->name);

                $streamHistory->date_end = new DateTimeImmutable();
                $broadcaster->is_live = false;
                $broadcaster->save();
                $streamHistory->save();

                continue;
            }
            $categoryArray = json_decode($streamHistory->categories);
            $category      = $this->categorySave($stream['game_id']);
            if (!in_array($category->id, $categoryArray)) {
                $categoryArray[]           = $category->id;
                $streamHistory->categories = json_encode($categoryArray);

                $this->botSender->changeGameNotification(
                    $stream['user_name'],
                    $stream['title'],
                    $category->name,
                    $stream['thumbnail_url']
                );
            }

            $streamHistory->average_num_viewers = ($streamHistory->average_num_viewers + $stream['viewer_count'])/2;
            $streamHistory->save();

            $this->sendActualClip($broadcaster);
        }
    }

    public function checkStartStream()
    {
        foreach (Broadcaster::where('is_live', false)->get() as $broadcaster) {
            $stream = $this->streamApi->getStream($broadcaster->twitch_id);
            if (!$stream || $stream['type'] !== 'live') continue;
            if (StreamHistory::where('twitch_id', $stream['id'])->first()) continue;
            $category = $this->categorySave($stream['game_id']);

            StreamHistory::create([
                'date_start'          => new DateTimeImmutable($stream['started_at']),
                'twitch_id'           => $stream['id'],
                'average_num_viewers' => $stream['viewer_count'],
                'categories'          => json_encode([$category->id]),
                'broadcaster_id'      => $broadcaster->id
            ]);

            $broadcaster->is_live = true;
            $broadcaster->save();

            $this->botSender->startStreamNotification(
                $stream['user_name'],
                $stream['title'],
                $category->name,
                $stream['thumbnail_url']
            );
        }
    }

    public function categorySave(string $categoryId): Category
    {
        $category = Category::where('twitch_id', $categoryId)->first();
        if ($category) return $category;

        $categoryResponse = $this->categoryApi->getCategory($categoryId);

        $category = Category::create([
            'name'      => $categoryResponse['name'],
            'twitch_id' => $categoryResponse['id'],
            'image_url' => $categoryResponse['box_art_url'],
        ]);

        return $category;
    }

    public function countStatistic()
    {
        foreach (Broadcaster::all() as $broadcaster) {
            $subCount    = $this->broadcasterApi->getSubsCount($broadcaster->twitch_id);
            $bannedCount = $this->broadcasterApi->getBannedUsersCount($broadcaster->twitch_id);

            SubsCount::create([
                'broadcaster_id' => $broadcaster->id,
                'count'          => $subCount
            ]);
            BannedUsersCount::create([
                'broadcaster_id' => $broadcaster->id,
                'count'          => $bannedCount
            ]);
        }
    }

    public function sendActualClip(Broadcaster $broadcaster)
    {
        $clip = $this->clipApi->getClipByBroadcasterAndDate(
            $broadcaster->twitch_id,
            new DateTimeImmutable('-5 minutes'),
            new DateTimeImmutable()
        );
        if (!$clip) return;

        $rateCountViewers = ($clip['view_count'] * 100) / $broadcaster->average_num_viewers;

        if ($rateCountViewers < Configuration::getRateClipCountViewers()) return;

        $this->botSender->clipNotification(
            $broadcaster->name,
            $clip['url'],
            $clip['title']
        );
    }
}
