<?php
declare(strict_types = 1);

namespace App\Telegram;

use BotMan\Drivers\Telegram\TelegramDriver;

class BotSender
{
    public function sendMessageToChannel(string $message)
    {
        $botman = Configuration::createBot();
        $botman->say($message, Configuration::channelId(), TelegramDriver::class);
    }
}
