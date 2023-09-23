<?php

namespace App\Contracts\Subscriber;

use App\Contracts\Contract;
use App\Interfaces\EventsSubscribersRepositoryInterface;

class CreateEventSubscriberContract extends Contract
{
    public function __construct(
        protected EventsSubscribersRepositoryInterface $eventsSubscribers
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

        return $this;
    }

    private function eventStatusShouldBeActive(bool $status): void
    {
        if (!$status) {
            $this->isValid = false;
            array_push($this->errors, 'Evento inativo. Inscrição não realizada.');
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
            array_push($this->errors, 'Inscrição já realizada anteriormente.');
        }
    }
}
