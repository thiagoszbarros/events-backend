<?php

namespace App\Repositories;

use App\Interfaces\CRUD;
use App\Models\Event;

class EventRepository implements CRUD
{
    public function __construct(private Event $event)
    {
    }

    public function index($offset = null)
    {
        return $this->event::take($offset)
            ->whereStatus(true)
            ->get();
    }

    public function store(object $event)
    {
        return $this->event->create([
            'name' => $event->name,
            'start_date' => $event->start_date,
            'end_date' => $event->end_date,
            'status' => $event->status
        ]);
    }

    public function update(string $id, object $event)
    {
        $this->event->find($id)->update([
            'name' => $event->name,
            'start_date' => $event->start_date,
            'end_date' => $event->end_date,
            'status' => $event->status
        ]);
    }

    public function delete(string $id)
    {
        $this->event->destroy($id);
    }
}
