<?php

namespace App\Services\Subscribers;

use App\Interfaces\SubscriberRepositoryInterface;
use App\Services\Contract;
use App\Shared\Dtos\ResultDto;
use Illuminate\Http\Response;

class ListSubscribersByEvent extends Contract
{
    public function __construct(
        protected SubscriberRepositoryInterface $subscriber
    ) {
    }

    public function execute(int $eventId): ResultDto
    {
        return new ResultDto(
            $this->subscriber->getByEventId($eventId),
            Response::HTTP_OK
        );
    }
}
