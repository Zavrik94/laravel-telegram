<?php

namespace Zavrik\LaravelTelegram\CLI;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Telegram\Bot\Api;
use Zavrik\LaravelTelegram\Models\TelegramBot;
use Zavrik\LaravelTelegram\Services\TelegramBotService;
use Zavrik\LaravelTelegram\Services\TelegramService;

class RegisterBot extends Command
{
    protected $signature = 'telegram:bot:register {--host=}';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = null;
        while ($name === null) {
            $name = $this->ask('Write Bot Name');
        }

        $title = $this->anticipate('Write Bot Title', [Str::title($name)], default: Str::title($name));
        $token = null;
        while ($token === null) {
            $token = $this->ask('Set Bot Token');
        }
        $bot = new TelegramBot([
            'name' => $name,
            'title' => $title,
            'token' => $token,
        ]);
        $bot->save();

        $bot->service()->registerBotWebHook();
    }
}
