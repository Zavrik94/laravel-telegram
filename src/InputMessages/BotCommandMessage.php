<?php

namespace Zavrik\LaravelTelegram\InputMessages;


class BotCommandMessage extends AbstractMessage
{
    public function isEntryCommand(): bool
    {
        return $this->message['text'] === '/start';
    }
}
