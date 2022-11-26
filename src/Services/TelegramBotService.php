<?php

namespace Zavrik\LaravelTelegram\Services;

use App\Containers\AppSection\Telegram\Models\TelegramUser;
use Exception;
use Hashids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\URL;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;
use Zavrik\LaravelTelegram\Models\TelegramBot;
use Zavrik\LaravelTelegram\Models\TelegramBotUser;

class TelegramBotService
{
    public function __construct(protected TelegramBot $bot)
    {
    }

    /**
     * @throws TelegramSDKException
     */
    public function registerBotWebHook(): bool
    {
        $params = ['url' => route('telegram_web_hook', ['bot_id' => $this->bot->getKey()])];
        $certificatePath = config('telegram.certificate_path', false);

        if ($certificatePath) {
            $params['certificate'] = $certificatePath;
        }

        return $this->bot->api()->setWebhook($params);
    }

    public function sendText(int $telegramId, string $text): void
    {
        $this->bot->api()->sendMessage([
            'chat_id' => $telegramId,
            'text'  => $text,
        ]);
    }

    public function sendHtmlMessage(int $telegramId, string $html): void
    {
        $this->bot->api()->sendMessage([
            'chat_id' => $telegramId,
            'text'  => $html,
            'parse_mode' => 'html'
        ]);
    }

    public function createUser(int $telegramId): TelegramBotUser
    {
        $telegramUser = new TelegramBotUser([
            'telegram_id' => $telegramId,
            'bot_id' => $this->bot->getKey(),
        ]);

        $telegramUser->save();

        return $telegramUser;
    }

    /**
     * @param int $telegramId
     * @param int $userId
     * @return TelegramBotUser
     * @throws Exception
     */
    public function setUserIdToTelegramUser(int $telegramId, int $userId): Model
    {
        $telegramUser = $this->getUserByTelegramId($telegramId);

        if ($telegramUser->user !== null) {
            throw new Exception("User Already Logged In");
        }

        $telegramUser->update([
            'user_id' => $userId
        ]);

        return $telegramUser;
    }

    /**
     * @param int $telegramID
     * @return TelegramBotUser
     * @throw ModelNotFoundException
     */
    public function getUserByTelegramId(int $telegramID): Model
    {
        return TelegramBotUser::query()
            ->where('telegram_id', $telegramID)
            ->where('bot_id', $this->bot->getKey())
            ->firstOrFail();
    }

    /**
     * @return Collection<TelegramBotUser>
     */
    public function getAllUsers(): Collection
    {
        return TelegramBotUser::query()
            ->where('bot_id', $this->bot->getKey())
            ->get();
    }

    /**
     * @param string $name
     * @return TelegramBot
     */
    public static function findBotByName(string $name): Model
    {
        return TelegramBot::query()
            ->where('name', $name)
            ->firstOrFail();
    }

    /**
     * @param string $uuid
     * @return TelegramBot
     */
    public static function findBotByUuid(string $uuid): Model
    {
        return TelegramBot::query()
            ->find($uuid);
    }
}
