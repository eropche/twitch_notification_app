<?php
declare(strict_types = 1);

namespace App\TwitchApi;

use Illuminate\Support\Facades\Http;

class Authorization
{
    public function token(): bool
    {
        $params = [
            'client_id' => Configuration::clientId(),
            'client_secret' => Configuration::secretKey(),
            'grant_type' => 'client_credentials'
        ];
        $response = Http::post(Configuration::TWITCH_ID_DOMAIN.'oauth2/token', $params);
        if ($response->status() !== 200) return false;

        $path = app_path(Configuration::TOKEN_FILE);
        file_put_contents($path, $response->json()['access_token']);

        return true;
    }
}
