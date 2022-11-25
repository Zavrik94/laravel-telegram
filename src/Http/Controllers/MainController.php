<?php

declare(strict_types=1);

namespace Zavrik\LaravelTelegram\Http\Controllers;

use Hashids;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Zavrik\LaravelTelegram\Events\InputMessageEvent;
use Zavrik\LaravelTelegram\Models\TelegramBot;
use Zavrik\LaravelTelegram\Services\TelegramBotService;

class MainController extends Controller
{
    public function webHook(Request $request)
    {
        /** @var TelegramBot $bot */
        $bot = TelegramBotService::findBotByUuid($request->bot_id);

        InputMessageEvent::dispatch($bot, $request->get('message'));
    }
}
