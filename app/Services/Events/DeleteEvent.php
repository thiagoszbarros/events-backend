<?php

namespace App\Services\Events;

use Illuminate\Http\Response;
use App\Shared\Dtos\ResultDto;
use App\Interfaces\EventRepositoryInterface;

class DeleteEvent
{
    public function __construct(
        private EventRepositoryInterface $event,
    ) {
    }

    public function execute($id): ResultDto
    {
        $this->event
            ->delete($id);

        return new ResultDto('Evento excluído com sucesso.', Response::HTTP_OK);
    }
}
