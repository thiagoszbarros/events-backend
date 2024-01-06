<?php

namespace App\Interfaces;

interface EventsSubscribersRepositoryInterface
{
    public function findByEventIdAndSubscriverId(string $eventId, string $subscriberId): ?object;

    public function createEventSubscriber(string $eventId, string $subscriberId): void;
}
