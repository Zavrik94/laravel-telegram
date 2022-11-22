<?php

namespace Zavrik\LaravelTelegram\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Zavrik\LaravelTelegram\Models\TelegramBot;

class InputMessageEvent implements ShouldQueue
{
    use Dispatchable, SerializesModels, InteractsWithQueue;

    public function __construct(public TelegramBot $bot, public array $message)
    {
    }
}
