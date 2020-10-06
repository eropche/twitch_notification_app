<?php
declare(strict_types = 1);

namespace App\TwitchApi;

final class Configuration
{
    public const TWITCH_ID_DOMAIN = 'https://id.twitch.tv/';
    public const TWITCH_API_DOMAIN = 'https://api.twitch.tv/helix/';
    public const TOKEN_FILE = 'TwitchApi/token';

    public static function clientId()
    {
        return env('TWITCH_CLIENT_ID');
    }

    public static function secretKey()
    {
        return env('TWITCH_SECRET_KEY');
    }

    public static function redirectUri()
    {
        return env('TWITCH_REDIRECT_URI');
    }

    public static function authorizationToken(): ?string
    {
        $tokenFile = app_path(Configuration::TOKEN_FILE);
        if (!file_exists($tokenFile)) {
            return null;
        }
        return file_get_contents($tokenFile);
    }

    public static function refreshToken()
    {
        return '';
    }
}
