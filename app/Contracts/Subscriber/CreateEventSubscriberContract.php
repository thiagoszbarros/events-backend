<?php

namespace App\Contracts\Subscriber;

use App\Contracts\Contract;
use App\Interfaces\EventRepositoryInterface;
use App\Interfaces\EventsSubscribersRepositoryInterface;
use App\Interfaces\SubscriberRepositoryInterface;

class CreateEventSubscriberContract extends Contract
{
    public function __construct(
        protected EventsSubscribersRepositoryInterface $eventsSubscribers,
        protected SubscriberRepositoryInterface $subscriber,
        protected EventRepositoryInterface $event
    ) {
        parent::__construct();
    }

    public function validate(...$args): self
    {
        [
            $status,
            $eventId,
            $subscriberId
        ] = $args;

        $this->eventStatusShouldBeActive(
            status: $status
        );

        $this->isAlreadySubscribed(
            eventId: $eventId,
            subscriberId: $subscriberId
        );

        $this->hasDateConflict(
            eventId: $eventId,
            subscriberId: $subscriberId
        );

        return $this;
    }

    private function eventStatusShouldBeActive(bool $status): void
    {
        if (!$status) {
            $this->isValid = false;
            array_push($this->errors, 'Inscrição não realizada pois o evento está inativo.');
        }
    }

    private function isAlreadySubscribed(int $eventId, int $subscriberId): void
    {
        if ($this->eventsSubscribers
            ->findByEventIdAndSubscriverId(
                eventId: $eventId,
                subscriberId: $subscriberId
            )
        ) {
            $this->isValid = false;
            array_push($this->errors, 'Inscrição não realizada por já ter sido realizada anteriormente.');
        }
    }

    public function hasDateConflict($eventId, $subscriberId)
    {
        if ($this->event->hasDateConflict(
            eventId: $eventId,
            subscriberId: $subscriberId
        )) {
            $this->isValid = false;
            array_push($this->errors, 'Inscrição não realizada por conflito de data com outro evento.');
        }
    }
}
