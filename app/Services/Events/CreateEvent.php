<?php

namespace App\Services\Events;

use App\Http\Requests\EventRequest;
use App\Interfaces\EventRepositoryInterface;
use App\Shared\Dtos\ResultDto;
use Illuminate\Http\Response;

class CreateEvent
{
    public function __construct(
        private EventRepositoryInterface $event,
    ) {
    }

    public function execute(EventRequest $request): ResultDto
    {
        $this->event
            ->create($request);

        return new ResultDto(
            'Evento criado com sucesso.',
            Response::HTTP_CREATED
        );
    }
}
