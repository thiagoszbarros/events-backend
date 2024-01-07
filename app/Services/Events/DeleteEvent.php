<?php

declare(strict_types=1);

namespace App\Services\Events;

use App\Services\Contract;
use App\Interfaces\EventRepositoryInterface;

class DeleteEvent extends Contract
{
    public function __construct(
        private EventRepositoryInterface $event,
    ) {
    }

    public function execute(int $id): DeleteEvent
    {
        $this->event
            ->delete($id);

        return $this;
    }
}
