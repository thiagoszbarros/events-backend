<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Subscriber;
use App\ValueObjects\EventSubscrivers\EventSubscriberParams;
use Illuminate\Database\Eloquent\Collection;

interface SubscriberRepositoryInterface
{
    public function store(EventSubscriberParams $subscriber): Subscriber;

    public function getByEventId(int $event_id): Collection;
}
