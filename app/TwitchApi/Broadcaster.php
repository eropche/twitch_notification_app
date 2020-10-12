<?php
declare(strict_types = 1);

namespace App\TwitchApi;

use Illuminate\Support\Facades\Http;

class Broadcaster
{
    public function getBroadcastersByName(string $broadcasterNamesQuery, bool $liveOnly = false): array
    {
        $response = Http::withToken(Configuration::authorizationToken())
            ->withHeaders(['Client-Id' => Configuration::clientId()])
            ->get(Configuration::TWITCH_API_DOMAIN.'search/channels', [
                'query'     => $broadcasterNamesQuery,
                'live_only' => $liveOnly,
                'first'     => 1
            ]);

        return $response->json()['data'][0];
    }

    public function getChannelDescription(string $broadcasterId): string
    {
        $response = Http::withToken(Configuration::authorizationToken())
            ->withHeaders(['Client-Id' => Configuration::clientId()])
            ->get(Configuration::TWITCH_API_DOMAIN.'users', [
                'id' => $broadcasterId
            ]);

        return $response->json()['data'][0]['description'];
    }

    public function getSubsCount(string $broadcasterId): int
    {
        $response = Http::withToken(Configuration::authorizationToken())
            ->withHeaders(['Client-Id' => Configuration::clientId()])
            ->get(Configuration::TWITCH_API_DOMAIN.'subscriptions', [
                'broadcaster_id' => $broadcasterId
            ]);

        return count($response->json()['data']);
    }

    public function getBannedUsersCount(string $broadcasterId): int
    {
        $response = Http::withToken(Configuration::authorizationToken())
            ->withHeaders(['Client-Id' => Configuration::clientId()])
            ->get(Configuration::TWITCH_API_DOMAIN.'moderation/banned', [
                'broadcaster_id' => $broadcasterId
            ]);

        return count($response->json()['data']);
    }
}
