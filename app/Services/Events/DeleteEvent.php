<?php

namespace App\Services\Events;

use App\Interfaces\EventRepositoryInterface;
use App\Shared\Dtos\ResultDto;
use Illuminate\Http\Response;

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
