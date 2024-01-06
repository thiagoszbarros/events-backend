<?php

namespace App\Services\Events;

use App\Http\Requests\EventRequest;
use App\Shared\Dtos\ResultDto;
use App\Interfaces\EventRepositoryInterface;
use Illuminate\Http\Response;

class UpdateEvent
{
    public function __construct(
        private EventRepositoryInterface $event,
    ) {
    }
    
    public function execute(EventRequest $request, int $id): ResultDto
    {
        $this->event
            ->update($id, $request);

        return new ResultDto('Evento atualizado com sucesso.', Response::HTTP_OK);
    }
}
