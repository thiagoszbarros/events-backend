<?php

declare(strict_types=1);

namespace App\Services\Events;

use App\Http\Requests\Events\UpdateEventRequest;
use App\Interfaces\EventRepositoryInterface;
use App\Shared\Dtos\ResultDto;
use Illuminate\Http\Response;

class UpdateEvent
{
    public function __construct(
        private EventRepositoryInterface $event,
    ) {
    }

    public function execute(UpdateEventRequest $request, int $id): ResultDto
    {
        $this->event
            ->update($request->validated(), $id);

        return new ResultDto('Evento atualizado com sucesso.', Response::HTTP_OK);
    }
}
