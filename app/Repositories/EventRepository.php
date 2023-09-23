<?php

namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Carbon\Carbon;

class EventRepository implements EventRepositoryInterface
{
    public function __construct(
        private Event $event
    ) {
    }

    public function index(): object
    {
        return $this->event::whereStatus(
            true
        )
            ->get();
    }

    public function find(string $id): object
    {
        return $this->event
            ->find($id);
    }

    public function store(object $event): object
    {
        return $this->event
            ->create(
                [
                    'name' => $event->name,
                    'start_date' => Carbon::createFromFormat('Y-m-d', $event->start_date),
                    'end_date' => Carbon::createFromFormat('Y-m-d', $event->end_date),
                    'status' => 1
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
}
