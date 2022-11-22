<?php

namespace Zavrik\LaravelTelegram\InputMessages;

abstract class AbstractMessage
{
    public function __construct(public array $message)
    {
    }

    static function parseContent(array $message): static
    {
        return new static($message);
    }

    public static function parseMessage(array $message): static
    {
        if (isset($message['entities'])) {
            if ($message['entities'][0]['type'] === 'bot_command') {
                return BotCommandMessage::parseContent($message);
            }
        } else if (isset($message['text'])) {
            return TextMessage::parseContent($message);
        }

        throw new \Exception('Can`t Parse Message');
    }

    public function getChatId(): int
    {
        return $this->message['chat']['id'];
    }

    public function getCompanionId(): int
    {
        return $this->message['from']['id'];
    }
}
