<?php

namespace App\Repositories;

use App\Interfaces\SubscriberInterface;
use App\Models\Subscriber;

class SubscriberRepository implements SubscriberInterface
{

    public function __construct(private Subscriber $subscriber)
    {
    }
    public function index($offset = null)
    {
        return $this->subscriber::take($offset)->get();
    }

    public function store($subscriber)
    {
        return $this->subscriber::create([
            'name' => $subscriber->name,
            'email' => $subscriber->email,
            'cpf' => $subscriber->cpf,
        ]);
    }
}
