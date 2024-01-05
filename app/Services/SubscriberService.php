<?php

namespace App\Services;

use App\Contracts\Subscriber\CreateEventSubscriberContract;
use App\Enums\Errors;
use App\Http\Requests\SubscriberRequest;
use App\Interfaces\EventRepositoryInterface;
use App\Interfaces\EventsSubscribersRepositoryInterface;
use App\Interfaces\SubscriberRepositoryInterface;
use App\Shared\Dtos\ResultDto;

class SubscriberService
{
    public function __construct(
        protected CreateEventSubscriberContract $contract,
        protected EventRepositoryInterface $event,
        protected SubscriberRepositoryInterface $subscriber,
        protected EventsSubscribersRepositoryInterface $eventsSubscribers
    ) {
    }

    public function listByEvent($eventId): ResultDto
    {
        return new ResultDto(
            $this->subscriber->getByEventId($eventId), 200);
    }

    public function create(SubscriberRequest $request): object
    {
        $event = $this->event
            ->find($request->event_id);

        $subscriber = $this->subscriber
            ->store($request);

        $contract = $this->contract
            ->validate(
                $event->status,
                $event->id,
                $subscriber->id
            );

        if (! $contract->isValid) {
            return new ResultDto($contract->errors[Errors::FIRST->position()], 422);
        }

        $this->eventsSubscribers->store(
            $event->id,
            $subscriber->id
        );

        return new ResultDto('Inscrição realizada com sucesso.', 201);
    }
}
