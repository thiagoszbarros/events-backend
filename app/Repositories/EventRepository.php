<?php

namespace App\Repositories;

use App\Interfaces\CRUD;
use App\Models\Event;
use Carbon\Carbon;

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

    public function show(string $id)
    {
        return $this->event->find($id);
    }

    public function store(object $event)
    {
        return $this->event->create([
            'name' => $event->name,
            'start_date' => Carbon::createFromFormat('Y-m-d', $event->start_date),
            'end_date' => Carbon::createFromFormat('Y-m-d', $event->end_date),
            'status' => 1
        ]);
    }

    public function update(string $id, object $event)
    {
        $this->event->find($id)->update([
            'name' => $event->name,
            'start_date' => Carbon::createFromFormat('Y-m-d', $event->start_date),
            'end_date' => Carbon::createFromFormat('Y-m-d', $event->end_date),
        ]);
    }

    public function delete(string $id)
    {
        $this->event->destroy($id);
    }
}
