<?php

namespace App\Services;

use App\Contracts\Subscriber\CreateEventSubscriberContract;
use App\Enums\Errors;
use App\Http\Requests\SubscriberRequest;
use App\Interfaces\EventRepositoryInterface;
use App\Interfaces\EventsSubscribersRepositoryInterface;
use App\Interfaces\SubscriberRepositoryInterface;

class SubscriberService
{
    public function __construct(
        protected CreateEventSubscriberContract $contract,
        protected EventRepositoryInterface $event,
        protected SubscriberRepositoryInterface $subscriber,
        protected EventsSubscribersRepositoryInterface $eventsSubscribers
    ) {
    }

    public function create(SubscriberRequest $request): string
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

        if (! $contractValidation->isValid) {
            return $contractValidation->errors[Errors::FIRST->position()];
        }

        $this->eventsSubscribers->store(
            $event->id,
            $subscriber->id
        );

        return 'Inscrição realizada com sucesso.';
    }
}
