<?php

declare(strict_types=1);

namespace Zavrik\LaravelTelegram\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\HttpClients\HttpClientInterface;
use Zavrik\LaravelTelegram\Services\TelegramBotService;
use Zavrik\LaravelTelegram\Traits\Uuids;

/**
 * @property string $id
 * @property string $token
 * @property string $name
 * @property string $label
 * @property Collection $users
 */
class TelegramBot extends Model
{
    use Uuids;

    public $timestamps = false;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'token',
        'name',
        'title',
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
    protected string $resourceKey = 'TelegramBot';

    /**
     * @throws TelegramSDKException
     */
    public function api(bool $async = false, ?HttpClientInterface $httpClientHandler = null): Api
    {
        return new Api($this->token, $async, $httpClientHandler);
    }

    public function service(): TelegramBotService
    {
        return new TelegramBotService($this);
    }

    public static function getByName(string $name): static
    {
        return static::where('name', $name)->with(['users'])->first();
    }

    public function users(): HasMany
    {
        return $this->hasMany(TelegramBotUser::class, 'bot_id');
    }
}
