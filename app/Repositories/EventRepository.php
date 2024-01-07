<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

class EventRepository implements EventRepositoryInterface
{
    public function __construct(
        private Event $event
    ) {
    }

    public function getActives(): Collection
    {
        return $this->event::whereStatus(
            true
        )->get();
    }

    public function findById(int $id): ?Event
    {
        return $this->event
            ->find($id);
    }

    public function create(array $event): Event|false
    {
        return $this->event
            ->create($event);
    }

    public function update(array $event, int $id): void
    {
        $this->event
            ->whereId($id)
            ->update($event);
    }

    public function delete(int $id): void
    {
        $this->event->destroy($id);
    }

    public function hasDateConflict(int $eventId, int $subscriberId): bool
    {
        $eventToCheck = $this->event::find($eventId);

        return $this->event::where('id', '<>', $eventId)
            ->where(function ($query) use ($eventToCheck) {
                $query->where(function ($q) use ($eventToCheck) {
                    $q->where('start_date', '>=', $eventToCheck->start_date)
                        ->where('start_date', '<', $eventToCheck->end_date);
                })
                    ->orWhere(function ($q) use ($eventToCheck) {
                        $q->where('end_date', '>', $eventToCheck->start_date)
                            ->where('end_date', '<=', $eventToCheck->end_date);
                    })
                    ->orWhere(function ($q) use ($eventToCheck) {
                        $q->where('start_date', '<=', $eventToCheck->start_date)
                            ->where('end_date', '>=', $eventToCheck->end_date);
                    });
            })
            ->whereHas('subscribers', function ($q) use ($subscriberId) {
                $q->where('subscriber_id', $subscriberId);
            })->exists();
    }
}
