<?php

namespace App\Http\Controllers;

use App\Interfaces\CRUD;
use Illuminate\Http\Response;
use App\Http\Requests\EventRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Interfaces\SubscriberRepositoryInterface;

class EventController extends Controller
{
    public function __construct(
        private CRUD $event,
        private SubscriberRepositoryInterface $subscriber,
        private Log $log
    ) {
    }

    public function index(PaginationRequest $request): Response
    {
        try {
            return new Response(
                [
                    'data' => $this->event->index($request->offset)
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            $this->log::info($e);
            return new Response(
                [
                    'data' => []
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    public function store(EventRequest $request): Response
    {
        try {
            $this->event->store($request);
            return new Response(
                [
                    'data' => 'Evento criado com sucesso.',
                ],
                Response::HTTP_CREATED
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
            return new Response(
                [
                    'data' => $this->event->show($id),
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            $this->log::info($e);
            return new Response(
                [
                    'data' =>  'Não foi possível obter o evento.',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    public function update(EventRequest $request, string $id): Response
    {
        try {
            $this->event->update($id, $request);
            return new Response(
                [
                    'data' => 'Evento atualizado com sucesso.',
                ],
                Response::HTTP_OK
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
            $this->event->delete($id);
            return new Response(
                [
                    'data' => 'Evento excluído com sucesso.',
                ],
                Response::HTTP_OK
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

    public function subscribers(PaginationRequest $request): Response
    {
        try {
            return new Response(
                [
                    'data' => $this->subscriber->getByEventId($request->event_id)
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            $this->log::info($e);
            return new Response(
                [
                    'data' => []
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
