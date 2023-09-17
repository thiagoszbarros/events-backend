<?php

namespace App\Repositories;

use App\Models\Subscriber;
use App\Models\EventsSubscribers;
use App\Interfaces\EventsSubscribersInterface;

class EventsSubscribersRepository implements EventsSubscribersInterface
{
    public function __construct(
        private EventsSubscribers $eventSubscriber
        )
    {
    }

    public function store(object $eventSubscriber): void
    {
        $this->eventSubscriber::create([
            'event_id' => $eventSubscriber->event_id,
            'subscriber_id' => $eventSubscriber->subscriber_id
        ]);
    }
}
