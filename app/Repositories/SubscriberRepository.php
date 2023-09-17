<?php

namespace App\Repositories;

use App\Interfaces\SubscriberRepositoryInterface;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Collection;

class SubscriberRepository implements SubscriberRepositoryInterface
{

    public function __construct(private Subscriber $subscriber)
    {
    }
    public function index($offset = null): Collection
    {
        return $this->subscriber::take($offset)
            ->get();
    }

    public function store($subscriber): Subscriber
    {
        return $this->subscriber::create([
            'name' => $subscriber->name,
            'email' => $subscriber->email,
            'cpf' => $subscriber->cpf,
        ]);
    }

    public function getByEventId(string $eventId, int $offset = null): Collection
    {
        return $this->subscriber::whereHas('events', function ($query) use ($eventId) {
            $query->where('events.id', $eventId);
        })->take($offset)
            ->get();
    }
}
