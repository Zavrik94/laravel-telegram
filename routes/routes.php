<?php

Route::post(
    'telegram/webhook/{bot_id}',
    [Zavrik\LaravelTelegram\Http\Controllers\MainController::class, 'webHook']
)->name('telegram_web_hook');
