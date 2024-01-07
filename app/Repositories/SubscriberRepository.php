<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\SubscriberRepositoryInterface;
use App\Models\Subscriber;
use App\ValueObjects\Subscribers\FindSubscriberByIdOrCreateParams;
use Illuminate\Database\Eloquent\Collection;

class SubscriberRepository implements SubscriberRepositoryInterface
{
    public function __construct(
        private Subscriber $subscriber
    ) {
    }

    public function findSubscriberByIdOrCreate(FindSubscriberByIdOrCreateParams $params): Subscriber
    {
        return $this->subscriber::firstOrCreate(
            [
                'email' => $params->email,
            ],
            [
                'name' => $params->name,
                'cpf' => $params->cpf,
            ]
        );
    }

    public function getByEventId(int $eventId): Collection
    {
        return $this->subscriber::whereHas(
            'events',
            function ($query) use ($eventId): void {
                $query->where('events.id', $eventId);
            }
        )->get();
    }
}
