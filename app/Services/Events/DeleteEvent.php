<?php

declare(strict_types=1);

namespace App\Services\Events;

use App\Http\Requests\Id;
use App\Services\Contract;
use App\Interfaces\EventRepositoryInterface;

class DeleteEvent extends Contract
{
    public function __construct(
        private EventRepositoryInterface $event,
    ) {
    }

    public function execute(Id $id): DeleteEvent
    {
        $this->event
            ->delete($id->value);

        return $this;
    }
}
