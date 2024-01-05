<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Requests\SubscribersRequest;
use App\Services\EventService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function __construct(
        private EventService $service,
        private Log $log
    ) {
    }

    public function index(): Response
    {
        $result = $this->service->index();

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }

    public function store(EventRequest $request): Response
    {
        $result = $this->service
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
        $result = $this->service
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
        $result = $this->service->update($id, $request);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }

    public function destroy($id): Response
    {
        $result = $this->service
            ->delete($id);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }

    public function subscribers(SubscribersRequest $request): Response
    {
        $result = $this->service->subscribers($request->event_id);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }
}
