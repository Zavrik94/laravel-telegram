<?php

namespace Zavrik\LaravelTelegram\Services;

use App\Containers\AppSection\Telegram\Models\TelegramUser;
use Hashids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;
use Zavrik\LaravelTelegram\Models\TelegramBot;
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

    public function sendUrl(string $text, string $route): void
    {
        $keyboard = [
            ['7', '8', '9'],
            ['4', '5', '6'],
            ['1', '2', '3'],
            ['0']
        ];

        $replyMarkup = Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        $this->user->bot->api()->sendMessage([
            'chat_id' => $this->user->telegram_id,
            'text'  => $text,
            'parse_mode' => 'markdown',
            'reply_markup' => $replyMarkup
        ]);
    }
}
