<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Id;
use Illuminate\Http\Response;
use App\Services\Events\CreateEvent;
use App\Services\Events\DeleteEvent;
use App\Services\Events\UpdateEvent;
use App\Services\Events\FindEventById;
use App\Services\Events\GetActiveEvents;
use App\Http\Requests\Events\CreateEventRequest;
use App\Http\Requests\Events\UpdateEventRequest;

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
        return $this->response(
            $this->getActiveEvents->execute()
        );
    }

    public function store(CreateEventRequest $request): Response
    {
        return $this->response(
            $this->createEvent
                ->execute($request->validated()),
            Response::HTTP_CREATED
        );
    }

    public function show(Id $id): Response
    {
        return $this->response(
            $this->findEventById
                ->execute($id->value)
        );
    }

    public function update(UpdateEventRequest $request, Id $id): Response
    {
        return $this->response(
            $this->updateEvent->execute(
                $request->validated(),
                $id->value
            ),
            Response::HTTP_NO_CONTENT
        );
    }

    public function destroy(Id $id): Response
    {
        return $this->response(
            $this->deleteEvent
                ->execute($id->value),
                Response::HTTP_NO_CONTENT
        );
    }
}
