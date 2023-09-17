<?php

namespace App\Interfaces;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Collection;

interface SubscriberRepositoryInterface
{
    public function store($subscriber): Subscriber;
    public function getByEventId(string $event_id, int $offset = null): Collection;
}
