<?php

namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Carbon\Carbon;
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

    public function findById(string $id): Event|null
    {
        return $this->event
            ->find($id);
    }

    public function create(object $event): Event|false
    {
        return $this->event
            ->create(
                [
                    'name' => $event->name,
                    'start_date' => Carbon::createFromFormat('Y-m-d', $event->start_date),
                    'end_date' => Carbon::createFromFormat('Y-m-d', $event->end_date),
                    'status' => 1,
                ]
            );
    }

    public function update(string $id, object $event): void
    {
        $this->event->find(
            $id
        )
            ->update(
                [
                    'name' => $event->name,
                    'start_date' => Carbon::createFromFormat('Y-m-d', $event->start_date),
                    'end_date' => Carbon::createFromFormat('Y-m-d', $event->end_date),
                ]
            );
    }

    public function delete(string $id): void
    {
        $this->event->destroy($id);
    }

    public function hasDateConflict(string $eventId, string $subscriberId): bool
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
