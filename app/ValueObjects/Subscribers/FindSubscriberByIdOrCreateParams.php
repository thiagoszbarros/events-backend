<?php

namespace App\ValueObjects\Subscribers;

class FindSubscriberByIdOrCreateParams
{
    public function __construct(
        public readonly string $email,
        public readonly string $name,
        public readonly string $cpf,
    ) {
    }
}
