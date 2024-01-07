<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\EventsSubscribersRepositoryInterface;
use App\Models\EventsSubscribers;

class EventsSubscribersRepository implements EventsSubscribersRepositoryInterface
{
    public function __construct(
        private EventsSubscribers $eventSubscriber
    ) {
    }

    public function findByEventIdAndSubscriverId(
        int $eventId,
        int $subscriberId
    ): ?EventsSubscribers {
        return $this->eventSubscriber
            ->whereEventIdAndSubscriberId(
                $eventId,
                $subscriberId
            )
            ->first();
    }

    public function createEventSubscriber(
        int $eventId,
        int $subscriberId
    ): void {
        $this->eventSubscriber::create(
            [
                'event_id' => $eventId,
                'subscriber_id' => $subscriberId,
            ]
        );
    }
}
