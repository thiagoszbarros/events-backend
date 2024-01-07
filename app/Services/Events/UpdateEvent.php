<?php

declare(strict_types=1);

namespace App\Services\Events;

use App\Interfaces\EventRepositoryInterface;
use App\Services\Contract;

class UpdateEvent extends Contract
{
    public function __construct(
        private EventRepositoryInterface $event,
    ) {
    }

    public function execute(array $request, int $id): UpdateEvent
    {
        $this->event
            ->update($request, $id);

        return $this;
    }
}
