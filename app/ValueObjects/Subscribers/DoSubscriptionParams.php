<?php

namespace App\ValueObjects\Subscribers;

class DoSubscriptionParams
{
    public function __construct(
        public readonly int $eventId,
        public readonly string $email,
        public readonly string $name,
        public readonly string $cpf,
    ) {
    }
}
