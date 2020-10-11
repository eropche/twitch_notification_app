<?php
declare(strict_types = 1);

namespace App\Telegram;


class TwitchBotSender extends BotSender
{
    public function startStreamNotification(string $streamer, string $title, string $game, string $image)
    {
        $image = str_replace(['{width}', '{height}'], ['1920', '1200'], $image);
        $message = "
__".$streamer."__ подрубил
".$title."

Играет ".$game;

        $this->sendMessageWithImgToChannel($image, $message);
    }

    public function endStreamNotification(string $streamer)
    {
        $message = "__".$streamer."__ закончил";

        $this->sendMessageToChannel($message);
    }

    public function clipNotification(string $streamer, string $url, string $title)
    {
        $message = "
У __".$streamer."__ такое сейчас".

$title;

        $this->sendMessageWithVideoToChannel($url, $message);
    }

    public function changeGameNotification(string $streamer, string $title, string $game, string $image)
    {
        $image = str_replace(['{width}', '{height}'], ['1920', '1200'], $image);
        $message = "
__".$streamer."__ сменил игру
".$title."

Сейчас ".$game;

        $this->sendMessageWithImgToChannel($image, $message);
    }
}
