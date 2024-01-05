<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Services\EventService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService,
        private Log $log
    ) {
    }

    public function index(): Response
    {
        $result = $this->eventService->index();

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }

    public function store(EventRequest $request): Response
    {
        $result = $this->eventService
            ->store($request);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }

    public function show(string $id): Response
    {
        $result = $this->eventService
            ->find($id);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }

    public function update(EventRequest $request, string $id): Response
    {
        $result = $this->eventService->update($id, $request);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }

    public function destroy($id): Response
    {
        $result = $this->eventService
            ->delete($id);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }
}
