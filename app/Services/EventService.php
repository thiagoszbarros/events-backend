<?php

namespace App\Services;

use App\Interfaces\EventRepositoryInterface;
use App\Interfaces\SubscriberRepositoryInterface;
use App\Shared\Dtos\ResultDto;

class EventService
{
    public function __construct(
        private EventRepositoryInterface $event,
        private SubscriberRepositoryInterface $subscriber,
    ) {
    }

    public function index()
    {
        return new ResultDto($this->event->index(), 200);
    }

    public function store(object $request)
    {
        $this->event
            ->store($request);

        return new ResultDto('Evento criado com sucesso.', 201);
    }

    public function find(string $id)
    {
        return new ResultDto($this->event->find($id), 200);
    }

    public function update(string $id, object $request)
    {
        $this->event
            ->update($id, $request);

        return new ResultDto('Evento atualizado com sucesso.', 200);
    }

    public function delete($id)
    {
        $this->event
            ->delete($id);

        return new ResultDto('Evento excluído com sucesso.', 200);
    }
}
