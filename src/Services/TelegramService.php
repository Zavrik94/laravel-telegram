<?php

namespace Zavrik\LaravelTelegram\Services;

use Hashids;
use Illuminate\Support\Facades\URL;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;
use Zavrik\LaravelTelegram\Models\TelegramBot;

class TelegramService
{
    public function __construct(protected Telegram $telegram)
    {
    }

    /**
     * @throws TelegramSDKException
     */
    public function registerBotWebHook(TelegramBot $bot, ?string $host): bool
    {
        $urlGenerator = clone URL::getFacadeRoot();
        $urlGenerator->forceRootUrl($host);
        $urlGenerator->forceScheme('https');
        $url = route('telegram_web_hook', ['bot_id' => $bot->getKey()]);
        $params = ['url' => $url];
        $certificatePath = config('telegram.certificate_path', false);

        if ($certificatePath) {
            $params['certificate'] = $certificatePath;
        }

        return $bot->api()->setWebhook($params);
    }
}
