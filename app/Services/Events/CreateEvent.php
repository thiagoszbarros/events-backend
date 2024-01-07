<?php

declare(strict_types=1);

namespace App\Services\Events;

use App\Interfaces\EventRepositoryInterface;
use App\Services\Contract;

class CreateEvent extends Contract
{
    public function __construct(
        private EventRepositoryInterface $event,
    ) {
    }

    public function execute(array $request): CreateEvent
    {
        $this->event
            ->create([
                ...$request,
                ...['status' => true],
            ]);

        $this->message = 'Evento criado com sucesso.';

        return $this;
    }
}
