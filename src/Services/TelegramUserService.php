<?php

namespace Zavrik\LaravelTelegram\Services;

use Telegram\Bot\Keyboard\Keyboard;
use Zavrik\LaravelTelegram\Models\TelegramBotUser;

class TelegramUserService
{
    public function __construct(protected TelegramBotUser $user)
    {
    }

    public function sendMessage(string $text): void
    {
        $this->user->bot->service()->sendText($this->user->telegram_id, $text);
    }

    public function sendHtmlMessage(string $html): void
    {
        $this->user->bot->service()->sendHtmlMessage($this->user->telegram_id, $html);
    }

    public function sendUrl(string $text, string $route): void
    {
        $keyboard = [
            [
                Keyboard::inlineButton(['url' => $route,'text'=>'Login URL']),
            ]
        ];
        $replyMarkup = Keyboard::make([
            'inline_keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);

        $this->user->bot->api()->sendMessage([
            'chat_id' => $this->user->telegram_id,
            'text'  => $text,
            'parse_mode' => 'markdown',
            'reply_markup' => $replyMarkup
        ]);
    }

    public function sendKeyboard(array $keyboard, string $text = 'Please Select Option'): void
    {
        $replyMarkup = Keyboard::make([
          'keyboard'          => $keyboard,
          'resize_keyboard'   => true,
          'one_time_keyboard' => false,
        ]);

        $this->user->bot->api()->sendMessage([
            'chat_id' => $this->user->telegram_id,
            'text'  => $text,
            'parse_mode' => 'markdown',
            'reply_markup' => $replyMarkup
        ]);
    }
}
