<?php

namespace App\Services;

use App\Contracts\Subscriber\CreateEventSubscriberContract;
use App\Enums\Errors;
use App\Http\Requests\SubscriberRequest;
use App\Interfaces\EventRepositoryInterface;
use App\Interfaces\EventsSubscribersRepositoryInterface;
use App\Interfaces\SubscriberRepositoryInterface;
use App\Shared\Dtos\ResultDto;
use stdClass;

class SubscriberService
{
    public function __construct(
        protected CreateEventSubscriberContract $contract,
        protected EventRepositoryInterface $event,
        protected SubscriberRepositoryInterface $subscriber,
        protected EventsSubscribersRepositoryInterface $eventsSubscribers
    ) {
    }

    public function create(SubscriberRequest $request): object
    {
        $event = $this->event
            ->find($request->event_id);

        $subscriber = $this->subscriber
            ->store($request);

        $contractValidation = $this->contract
            ->validate(
                $event->status,
                $event->id,
                $subscriber->id
            );

        if (!$contractValidation->isValid) {
            return new ResultDto($contractValidation->errors[Errors::FIRST->position()], 422);
        }

        $this->eventsSubscribers->store(
            $event->id,
            $subscriber->id
        );

        return new ResultDto('Inscrição realizada com sucesso.', 201);
    }
}
