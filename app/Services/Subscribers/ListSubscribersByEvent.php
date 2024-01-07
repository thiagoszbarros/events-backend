<?php

declare(strict_types=1);

namespace App\Services\Subscribers;

use App\Interfaces\SubscriberRepositoryInterface;
use App\Services\Contract;

class ListSubscribersByEvent extends Contract
{
    public function __construct(
        protected SubscriberRepositoryInterface $subscriber
    ) {
    }

    public function execute(int $eventId): ListSubscribersByEvent
    {
        $this->data = $this->subscriber->getByEventId($eventId);
        
        return $this;
    }
}
