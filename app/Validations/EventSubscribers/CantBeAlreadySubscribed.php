<?php

namespace App\Validations\EventSubscribers;

use App\Interfaces\EventsSubscribersRepositoryInterface;
use App\Validations\Validation;
use Illuminate\Support\Facades\App;

class CantBeAlreadySubscribed extends Validation
{
    private readonly EventsSubscribersRepositoryInterface $eventsSubscribers;

    public function __construct(
        private readonly int $eventId,
        private readonly int $subscriberId,
    ) {
        $this->eventsSubscribers = App::make(EventsSubscribersRepositoryInterface::class);
    }

    public function rule(): \Closure
    {
        return fn (): bool => boolval(
            ! $this->eventsSubscribers
                ->findByEventIdAndSubscriverId(
                    eventId: $this->eventId,
                    subscriberId: $this->subscriberId
                )
        );
    }

    public function message(): string
    {
        return 'Inscrição não realizada por já ter sido realizada anteriormente.';
    }
}
