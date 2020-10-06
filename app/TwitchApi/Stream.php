<?php
declare(strict_types = 1);

namespace App\TwitchApi;

use Illuminate\Support\Facades\Http;

class Stream
{
    public function getStream(string $broadcasterId)
    {
        $response = Http::withToken(Configuration::authorizationToken())
            ->withHeaders(['Client-Id' => Configuration::clientId()])
            ->get(Configuration::TWITCH_API_DOMAIN.'streams', [
                'user_id' => $broadcasterId
            ]);

        return empty($response->json()['data']) ? null : $response->json()['data'][0];
    }
}
