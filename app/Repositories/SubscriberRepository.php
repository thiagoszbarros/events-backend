<?php

namespace App\Repositories;

use App\Interfaces\SubscriberInterface;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Collection;

class SubscriberRepository implements SubscriberInterface
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
}
