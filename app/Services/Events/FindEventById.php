<?php

declare(strict_types=1);

namespace App\Services\Events;

use App\Services\Contract;
use App\Interfaces\EventRepositoryInterface;

class FindEventById extends Contract
{
    public function __construct(
        private EventRepositoryInterface $event,
    ) {
    }

    public function execute(int $id): FindEventById
    {
        $this->data = $this->event->findById($id);
        
        return $this;
    }
}
