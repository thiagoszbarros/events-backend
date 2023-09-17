<?php

namespace App\Repositories;

use App\Interfaces\EventsSubscribersInterface;
use App\Models\EventsSubscribers;

class EventsSubscribersRepository implements EventsSubscribersInterface
{
    public function __construct(private EventsSubscribers $eventSubscriber)
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
