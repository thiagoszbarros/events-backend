<?php

declare(strict_types=1);

namespace App\Validations\EventSubscribers;

use App\Interfaces\EventRepositoryInterface;
use App\Repositories\EventRepository;
use App\Validations\Validation;
use Illuminate\Support\Facades\App;

class CantSubscribeTwoEventsAtSameTime extends Validation
{
    private readonly EventRepository $eventRepository;

    public function __construct(
        private readonly int $eventId,
        private readonly int $subscriberId,
    ) {
        $this->eventRepository = App::make(EventRepositoryInterface::class);
    }

    public function rule(): \Closure
    {
        return fn (): bool => ! $this->eventRepository->hasDateConflict(
            eventId: $this->eventId,
            subscriberId: $this->subscriberId
        );
    }

    public function message(): string
    {
        return 'Inscrição não realizada por conflito de data com outro evento.';
    }
}
