<?php
declare(strict_types = 1);

namespace App\TwitchApi;

use Illuminate\Support\Facades\Http;

class Category
{
    public function getCategory(string $gameId)
    {
        $response = Http::withToken(Configuration::authorizationToken())
            ->withHeaders(['Client-Id' => Configuration::clientId()])
            ->get(Configuration::TWITCH_API_DOMAIN.'games', [
                'id' => $gameId
            ]);

        return $response->json()['data'][0];
    }
}
