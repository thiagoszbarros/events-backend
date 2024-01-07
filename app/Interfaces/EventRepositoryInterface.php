<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

interface EventRepositoryInterface
{
    public function getActives(): Collection;

    public function findById(int $id): ?Event;

    public function create(array $event): Event|false;

    public function update(array $event, int $id): void;

    public function delete(int $id): void;

    public function hasDateConflict(int $eventId, int $subscriberId): bool;
}
