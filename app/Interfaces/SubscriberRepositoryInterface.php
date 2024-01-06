<?php

namespace App\Interfaces;

use App\Models\Subscriber;
use App\ValueObjects\EventSubscrivers\EventSubscriberParams;

interface SubscriberRepositoryInterface
{
    public function store(EventSubscriberParams $subscriber): Subscriber;

    public function getByEventId(string $event_id): ?object;
}
