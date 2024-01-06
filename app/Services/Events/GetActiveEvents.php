<?php

namespace App\Services\Events;

use App\Interfaces\EventRepositoryInterface;
use App\Shared\Dtos\ResultDto;
use Illuminate\Http\Response;

class GetActiveEvents
{
    public function __construct(
        private readonly EventRepositoryInterface $event,
    ) {
    }

    public function execute(): ResultDto
    {
        return new ResultDto(
            $this->event->getActives(),
            Response::HTTP_OK
        );
    }
}
