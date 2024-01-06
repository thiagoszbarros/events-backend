<?php

namespace App\Interfaces;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

interface EventRepositoryInterface
{
    public function getActives(): Collection;

    public function findById(string $id): ?Event;

    public function create(object $event): Event|false;

    public function update(array $event, int $id): void;

    public function delete(string $id): void;

    public function hasDateConflict(string $eventId, string $subscriberId): bool;
}
