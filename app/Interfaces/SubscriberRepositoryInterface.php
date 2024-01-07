<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Subscriber;
use App\ValueObjects\Subscribers\FindSubscriberByIdOrCreateParams;
use Illuminate\Database\Eloquent\Collection;

interface SubscriberRepositoryInterface
{
    public function findSubscriberByIdOrCreate(FindSubscriberByIdOrCreateParams $subscriber): Subscriber;

    public function getByEventId(int $eventId): Collection;
}
