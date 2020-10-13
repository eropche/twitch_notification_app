<?php
declare(strict_types = 1);

namespace App\Telegram;


class TwitchBotSender extends BotSender
{
    public function startStreamNotification(string $streamer, string $title, string $game, string $image)
    {
        $message = "
__".$streamer."__ подрубил
".$title."

Играет ".$game;

        $this->sendMessageWithImgToChannel($this->imageFormatting($image), $message);
    }

    public function endStreamNotification(string $streamer)
    {
        $message = "<b>".$streamer."</b> закончил";

        $this->sendMessageToChannel($message);
    }

    public function clipNotification(string $streamer, string $url, string $title)
    {
        $message = "
У <b>".$streamer."</b> такое сейчас <a href='".$url."'>".$title."</a>";

        $this->sendMessageToChannel($message);
    }

    public function changeGameNotification(string $streamer, string $title, string $game, string $image)
    {
        $message = "
__".$streamer."__ сменил игру
".$title."

Сейчас ".$game;

        $this->sendMessageWithImgToChannel($this->imageFormatting($image), $message);
    }

    protected function imageFormatting(string $img): string
    {
        $img = str_replace(['{width}', '{height}'], ['1920', '1200'], $img); // подставляем размер
        $img = $img.'?a='.time();                                            // добавляем параметр против кеширования

        return $img;
    }
}
