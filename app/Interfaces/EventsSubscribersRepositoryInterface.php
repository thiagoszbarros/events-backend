<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\EventsSubscribers;

interface EventsSubscribersRepositoryInterface
{
    public function findByEventIdAndSubscriverId(int $eventId, int $subscriberId): ?EventsSubscribers;

    public function createEventSubscriber(int $eventId, int $subscriberId): void;
}
