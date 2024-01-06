<?php

namespace App\Repositories;

use App\Interfaces\SubscriberRepositoryInterface;
use App\Models\Subscriber;
use App\ValueObjects\EventSubscrivers\EventSubscriberParams;
use Illuminate\Database\Eloquent\Collection;

class SubscriberRepository implements SubscriberRepositoryInterface
{
    public function __construct(
        private Subscriber $subscriber
    ) {
    }

    public function store(EventSubscriberParams $subscriber): Subscriber
    {
        return $this->subscriber::firstOrCreate(
            [
                'email' => $subscriber->email,
            ],
            [
                'name' => $subscriber->name,
                'cpf' => $subscriber->cpf,
            ]
        );
    }

    public function getByEventId(string $eventId): Collection
    {
        return $this->subscriber::whereHas(
            'events',
            function ($query) use ($eventId) {
                $query->where('events.id', $eventId);
            }
        )->get();
    }
}
