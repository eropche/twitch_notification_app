<?php
declare(strict_types = 1);

namespace App\Telegram;

use Illuminate\Support\Facades\Http;

class BotSender
{
    const TELEGRAM_BOT_URL = 'https://api.telegram.org/bot';

    protected function botToken()
    {
        return env('TELEGRAM_BOT_TOKEN');
    }

    protected function channelId()
    {
        return env('TELEGRAM_CHANNEL_ID');
    }

    protected function sendMessageToChannel(string $message)
    {
        Http::get(self::TELEGRAM_BOT_URL.$this->botToken().'/sendMessage', [
            'chat_id' => $this->channelId(),
            'text'    => $message
        ]);
    }

    protected function sendMessageWithImgToChannel(string $img, string $message)
    {
        Http::get(self::TELEGRAM_BOT_URL.$this->botToken().'/sendPhoto', [
            'chat_id'    => $this->channelId(),
            'photo'      => $img,
            'caption'    => $message
        ]);
    }

    protected function sendMessageWithVideoToChannel(string $clip, string $message)
    {
        Http::get(self::TELEGRAM_BOT_URL.$this->botToken().'/sendVideo', [
            'chat_id'    => $this->channelId(),
            'video'      => $clip,
            'caption'    => $message
        ]);
    }
}
