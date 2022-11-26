<?php

declare(strict_types=1);

namespace Zavrik\LaravelTelegram\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Zavrik\LaravelTelegram\Services\TelegramUserService;

/**
 * @property string $id
 * @property TelegramUserInterface | null $user
 * @property TelegramBot $bot
 * @property int $telegram_id
 *
 */
class TelegramBotUser extends Model
{
    public $timestamps = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'bot_id',
        'telegram_id',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
    ];

    /**
     * @var array<string>
     */
    protected $hidden = [
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'TelegramBotUser';

    public function bot(): BelongsTo
    {
        return $this->belongsTo(TelegramBot::class, 'bot_id');
    }

    /**
     * @throws Exception
     */
    public function user(): BelongsTo
    {
        $userClass = config('telegram.user_model');

        if (!in_array(TelegramUserInterface::class, class_implements($userClass))) {
            throw new Exception('User Model must implement ' . TelegramUserInterface::class);
        }

        return $this->belongsTo($userClass, 'user_id');
    }

    public function service(): TelegramUserService
    {
        return new TelegramUserService($this);
    }
}
