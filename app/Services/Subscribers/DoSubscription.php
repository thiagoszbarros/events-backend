<?php

declare(strict_types=1);

namespace App\Services\Subscribers;

use App\Interfaces\SubscriberRepositoryInterface;
use App\Repositories\EventsSubscribersRepository;
use App\Services\Contract;
use App\Services\Events\FindEventById;
use App\Validations\EventSubscribers\CantBeAlreadySubscribed;
use App\Validations\EventSubscribers\CantSubscribeTwoEventsAtSameTime;
use App\Validations\EventSubscribers\EventShouldBeActive;
use App\ValueObjects\Subscribers\DoSubscriptionParams;
use App\ValueObjects\Subscribers\FindSubscriberByIdOrCreateParams;

class DoSubscription extends Contract
{
    public function __construct(
        private readonly FindEventById $findEventById,
        private readonly SubscriberRepositoryInterface $subscriberRepository,
        private readonly EventsSubscribersRepository $eventsSubscribersRepository,
    ) {
    }

    public function execute(DoSubscriptionParams $params): DoSubscription
    {
        $this->validate(
            new EventShouldBeActive(
                status: $this->findEventById
                    ->execute($params->eventId)
                    ->data
                        ?->status
            )
        );

        $subscriber = $this->subscriberRepository
            ->findSubscriberByIdOrCreate(
                new FindSubscriberByIdOrCreateParams(
                    $params->email,
                    $params->name,
                    $params->cpf
                )
            );

        $this->validate(
            new CantBeAlreadySubscribed(
                eventId: $params->eventId,
                subscriberId: $subscriber->id
            )
        );

        $this->validate(
            new CantSubscribeTwoEventsAtSameTime(
                eventId: $params->eventId,
                subscriberId: $subscriber->id
            )
        );

        if (! $this->isValid) {
            return $this;
        }

        $this->eventsSubscribersRepository->createEventSubscriber(
            $params->eventId,
            $subscriber->id
        );

        $this->message = 'Inscrição realizada com sucesso.';

        return $this;
    }
}
