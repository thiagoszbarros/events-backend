<?php

namespace App\Repositories;

use App\Models\EventsSubscribers;
use App\Interfaces\EventsSubscribersRepositoryInterface;

class EventsSubscribersRepository implements EventsSubscribersRepositoryInterface
{
    public function __construct(
        private EventsSubscribers $eventSubscriber
    ) {
    }

    public function findByEventIdAndSubscriverId(
        $eventId,
        $subscriberId
    ): object|null {
        return $this->eventSubscriber
            ->whereEventIdAndSubscriberId(
                $eventId,
                $subscriberId
            )
            ->first();
    }

    public function store(
        string $eventId,
        string $subscriberId
    ): void {
        $this->eventSubscriber::create(
            [
                'event_id' => $eventId,
                'subscriber_id' => $subscriberId
            ]
        );
    }
}
