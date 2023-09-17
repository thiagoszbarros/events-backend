<?php

namespace App\Interfaces;

interface EventsSubscribersInterface
{
    public function store(object $eventSubscriber): void;
}
