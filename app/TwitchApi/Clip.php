<?php
declare(strict_types = 1);

namespace App\TwitchApi;

use DateTimeInterface;
use Illuminate\Support\Facades\Http;

class Clip
{
    public function getClipByBroadcasterAndDate(string $broadcasterId, DateTimeInterface $dateStart, DateTimeInterface $dateEnd)
    {
        $response = Http::withToken(Configuration::authorizationToken())
            ->withHeaders(['Client-Id' => Configuration::clientId()])
            ->get(Configuration::TWITCH_API_DOMAIN.'clips', [
                'broadcaster_id' => $broadcasterId,
                'started_at'     => $dateStart->format(DateTimeInterface::RFC3339),
                'ended_at'       => $dateEnd->format(DateTimeInterface::RFC3339),
                'first'          => 1
            ]);

        return empty($response->json()['data']) ? null : $response->json()['data'][0];
    }
}
