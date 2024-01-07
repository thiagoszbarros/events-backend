<?php

declare(strict_types=1);

namespace App\Services\Events;

use App\Http\Requests\Id;
use App\Services\Contract;
use App\Interfaces\EventRepositoryInterface;
use App\Http\Requests\Events\UpdateEventRequest;

class UpdateEvent extends Contract
{
    public function __construct(
        private EventRepositoryInterface $event,
    ) {
    }

    public function execute(UpdateEventRequest $request, Id $id): UpdateEvent
    {
        $this->event
            ->update($request->validated(), $id->value);

        return $this;
    }
}
