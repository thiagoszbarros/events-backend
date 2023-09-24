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
        try {
            $result = $this->service->index();

            return new Response(
                [
                    'data' => $result->data,
                ],
                $result->code
            );
        } catch (\Exception $e) {
            $this->log::info($e);

            return new Response(
                [
                    'data' => [],
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    public function store(EventRequest $request): Response
    {
        try {
            $result = $this->service
                ->store($request);

            return new Response(
                [
                    'data' => $result->data,
                ],
                $result->code
            );
        } catch (\Exception $e) {
            $this->log::info($e);

            return new Response(
                [
                    'data' => 'Não foi possível criar o evento.',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    public function show(string $id): Response
    {
        try {
            $result = $this->service
                ->find($id);

            return new Response(
                [
                    'data' => $result->data,
                ],
                $result->code
            );
        } catch (\Exception $e) {
            $this->log::info($e);

            return new Response(
                [
                    'data' => 'Não foi possível obter o evento.',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    public function update(EventRequest $request, string $id): Response
    {
        try {
            $result = $this->service->update($id, $request);

            return new Response(
                [
                    'data' => $result->data,
                ],
                $result->code
            );
        } catch (\Exception $e) {
            $this->log::info($e);

            return new Response(
                [
                    'data' => 'Não foi possível atualizar o evento.',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    public function destroy($id): Response
    {
        try {
            $result = $this->service
                ->delete($id);

            return new Response(
                [
                    'data' => $result->data,
                ],
                $result->code
            );
        } catch (\Exception $e) {
            $this->log::info($e);

            return new Response(
                [
                    'data' => 'Não foi possível excluir o evento.',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    public function subscribers(SubscribersRequest $request): Response
    {
        try {
            $result = $this->service->subscribers($request->event_id);

            return new Response(
                [
                    'data' => $result->data,
                ],
                $result->code
            );
        } catch (\Exception $e) {
            $this->log::info($e);

            return new Response(
                [
                    'data' => [],
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
