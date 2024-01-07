<?php

declare(strict_types=1);

namespace App\Services\Events;

use App\Http\Requests\Id;
use App\Services\Contract;
use App\Interfaces\EventRepositoryInterface;

class FindEventById extends Contract
{
    public function __construct(
        private EventRepositoryInterface $event,
    ) {
    }

    public function execute(Id $id): FindEventById
    {
        $this->data = $this->event->findById($id->value);
        
        return $this;
    }
}
