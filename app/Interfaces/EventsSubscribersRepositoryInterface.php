<?php

namespace App\Interfaces;

interface EventsSubscribersRepositoryInterface
{
    public function findByEventIdAndSubscriverId(string $eventId, string $subscriberId): object|null;
    public function store(string $eventId, string $subscriberId): void;
}
