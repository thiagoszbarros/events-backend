<?php

namespace App\Services\Events;

use App\Shared\Dtos\ResultDto;
use App\Interfaces\EventRepositoryInterface;
use Illuminate\Http\Response;

class FindEventById
{
    public function __construct(
        private EventRepositoryInterface $event,
    ) {
    }

    public function execute(int $id): ResultDto
    {
        return new ResultDto($this->event->findById($id), Response::HTTP_OK);
    }
}
