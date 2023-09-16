<?php

namespace App\Http\Controllers;

use App\Interfaces\CRUD;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\EventRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function __construct(
        private CRUD $event,
        private Log $log
    ) {
    }

    public function index(PaginationRequest $request)
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

    public function store(EventRequest $request)
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

    public function update(EventRequest $request, string $id)
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

    public function destroy($id)
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
}
