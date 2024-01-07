<?php

declare(strict_types=1);

namespace App\Services\Events;

use App\Interfaces\EventRepositoryInterface;
use App\Services\Contract;

class GetActiveEvents extends Contract
{
    public function __construct(
        private readonly EventRepositoryInterface $event,
    ) {
    }

    public function execute(): GetActiveEvents
    {
        $this->data = $this->event
            ->getActives();

        return $this;
    }
}
