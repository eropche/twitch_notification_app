<?php
declare(strict_types = 1);

namespace App\Telegram;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;

final class Configuration
{
    public static function botToken()
    {
        return env('TELEGRAM_BOT_TOKEN');
    }

    public static function channelId()
    {
        return env('TELEGRAM_CHANNEL_ID');
    }

    public static function getConfig()
    {
        return [
             "telegram" => [
                 "token" => self::botToken()
             ]
        ];
    }

    public static function createBot(): BotMan
    {
        DriverManager::loadDriver(TelegramDriver::class);

        return BotManFactory::create(self::getConfig());
    }
}
