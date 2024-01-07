<?php

declare(strict_types=1);

namespace App\Services\Subscribers;

use App\Http\Requests\Subscribers\CreateSubscriberRequest;
use App\Interfaces\EventRepositoryInterface;
use App\Interfaces\SubscriberRepositoryInterface;
use App\Repositories\EventsSubscribersRepository;
use App\Services\Contract;
use App\Validations\EventSubscribers\CantBeAlreadySubscribed;
use App\Validations\EventSubscribers\CantSubscribeTwoEventsAtSameTime;
use App\Validations\EventSubscribers\EventShouldBeActive;
use App\ValueObjects\EventSubscrivers\EventSubscriberParams;

class CreateSubscriber extends Contract
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
        private readonly SubscriberRepositoryInterface $subscriberRepository,
        private readonly EventsSubscribersRepository $eventsSubscribersRepository,
    ) {
    }

    public function execute(CreateSubscriberRequest $request): CreateSubscriber
    {
        $event = $this->eventRepository
            ->findById(intval($request->event_id));

        $this->validate(
            new EventShouldBeActive(status: $event?->status)
        );

        $subscriber = $this->subscriberRepository
            ->store(
                new EventSubscriberParams(
                    $request->email,
                    $request->name,
                    $request->cpf
                )
            );

        $this->validate(
            new CantBeAlreadySubscribed(
                eventId: $event->id,
                subscriberId: $subscriber->id
            )
        );

        $this->validate(
            new CantSubscribeTwoEventsAtSameTime(
                eventId: $event->id,
                subscriberId: $subscriber->id
            )
        );

        if (! $this->isValid) {
            return $this;
        }

        $this->eventsSubscribersRepository->createEventSubscriber(
            $event->id,
            $subscriber->id
        );

        $this->message = 'Inscrição realizada com sucesso.';

        return $this;
    }
}
