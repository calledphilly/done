<?php

namespace App\Message;

final class SendArticleNotification
{
    public function __construct(
        public readonly int $articleId
    ) {}

    public function getArticleId(): int
    {
        return $this->articleId;
    }
}