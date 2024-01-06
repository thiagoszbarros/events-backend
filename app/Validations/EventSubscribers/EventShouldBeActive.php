<?php

namespace App\Validations\EventSubscribers;

use App\Validations\Validation;

class EventShouldBeActive extends Validation
{
    public function __construct(
        public readonly bool $status,
    ) {
    }

    public function rule(): \Closure
    {
        return fn (): bool => $this->status;
    }

    public function message(): string
    {
        return 'Inscrição não realizada pois o evento está inativo.';
    }
}
