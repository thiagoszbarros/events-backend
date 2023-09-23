<?php

namespace App\Interfaces;

interface SubscriberRepositoryInterface
{
    public function store($subscriber): object;

    public function getByEventId(string $event_id): ?object;
}
