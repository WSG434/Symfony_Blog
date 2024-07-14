<?php
declare(strict_types=1);

namespace App\Message;

class ContentWatchMessage
{
    public function __construct(
        private readonly string $content,
    ) {
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
