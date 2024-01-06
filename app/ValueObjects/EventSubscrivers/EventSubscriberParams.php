<?php

namespace App\ValueObjects\EventSubscrivers;

class EventSubscriberParams
{
    public function __construct(
        public readonly string $email,
        public readonly string $name,
        public readonly string $cpf,
    ) {
    }
}
