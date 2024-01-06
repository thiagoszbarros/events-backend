<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Requests\Events\UpdateEventRequest;
use App\Services\Events\CreateEvent;
use App\Services\Events\DeleteEvent;
use App\Services\Events\FindEventById;
use App\Services\Events\GetActiveEvents;
use App\Services\Events\UpdateEvent;
use Illuminate\Http\Response;

class EventController extends Controller
{
    public function __construct(
        private readonly CreateEvent $createEvent,
        private readonly GetActiveEvents $getActiveEvents,
        private readonly FindEventById $findEventById,
        private readonly UpdateEvent $updateEvent,
        private readonly DeleteEvent $deleteEvent,
    ) {
    }

    public function index(): Response
    {
        $result = $this->getActiveEvents->execute();

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }

    public function store(EventRequest $request): Response
    {
        $result = $this->createEvent
            ->execute($request);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }

    public function show(int $id): Response
    {
        $result = $this->findEventById
            ->execute($id);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }

    public function update(UpdateEventRequest $request, int $id): Response
    {
        $result = $this->updateEvent->execute($request, $id);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }

    public function destroy($id): Response
    {
        $result = $this->deleteEvent
            ->execute($id);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }
}
