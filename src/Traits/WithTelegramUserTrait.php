<?php

namespace Zavrik\LaravelTelegram\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Zavrik\LaravelTelegram\Models\TelegramBotUser;

/**
 * @property TelegramBotUser | null $telegram
 */
trait WithTelegramUserTrait
{
    public function telegram(): HasOne
    {
        return $this->hasOne(TelegramBotUser::class, 'user_id');
    }
}
