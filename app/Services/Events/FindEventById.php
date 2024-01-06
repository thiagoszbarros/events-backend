<?php

namespace App\Services\Events;

use App\Interfaces\EventRepositoryInterface;
use App\Shared\Dtos\ResultDto;
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
