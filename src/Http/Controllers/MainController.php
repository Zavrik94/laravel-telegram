<?php

declare(strict_types=1);

namespace Zavrik\LaravelTelegram\Http\Controllers;

use Hashids;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Zavrik\LaravelTelegram\Events\InputMessageEvent;
use Zavrik\LaravelTelegram\Models\TelegramBot;

class MainController extends Controller
{
    public function webHook(Request $request)
    {
        $bot = TelegramBot::find($request->bot_id);

        InputMessageEvent::dispatch($bot, $request->get('message'));
    }
}
