<?php

namespace App\Services\Subscribers;

use App\Http\Requests\SubscriberRequest;
use App\Interfaces\EventRepositoryInterface;
use App\Interfaces\SubscriberRepositoryInterface;
use App\Repositories\EventsSubscribersRepository;
use App\Services\Contract;
use App\Shared\Dtos\ResultDto;
use App\Validations\EventSubscribers\CantBeAlreadySubscribed;
use App\Validations\EventSubscribers\CantSubscribeTwoEventsAtSameTime;
use App\Validations\EventSubscribers\EventShouldBeActive;
use App\ValueObjects\EventSubscrivers\EventSubscriberParams;
use Illuminate\Http\Response;

class CreateSubscriber extends Contract
{
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
        private readonly SubscriberRepositoryInterface $subscriberRepository,
        private readonly EventsSubscribersRepository $eventsSubscribersRepository,
    ) {
    }

    public function execute(SubscriberRequest $request): object
    {
        $event = $this->eventRepository
            ->findById($request->event_id);

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

        if (!$this->isValid) {
            return new ResultDto(
                $this->error,
                Response::HTTP_BAD_REQUEST
            );
        }

        $this->eventsSubscribersRepository->createEventSubscriber(
            $event->id,
            $subscriber->id
        );

        return new ResultDto(
            'Inscrição realizada com sucesso.',
            Response::HTTP_CREATED
        );
    }
}
