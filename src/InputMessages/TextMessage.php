<?php

namespace Zavrik\LaravelTelegram\InputMessages;


class TextMessage extends AbstractMessage
{
    public function getMessageText(): string
    {
        return $this->message['text'];
    }
}
