<?php

declare(strict_types=1);

namespace App\Services\Events;

use App\Interfaces\EventRepositoryInterface;
use App\Services\Contract;

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
