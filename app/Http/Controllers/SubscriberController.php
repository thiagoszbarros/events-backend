<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Subscribers\CreateSubscriberRequest;
use App\Http\Requests\Subscribers\ListSubscribersByEventRequest;
use App\Services\Subscribers\CreateSubscriber;
use App\Services\Subscribers\ListSubscribersByEvent;
use Illuminate\Http\Response;

class SubscriberController extends Controller
{
    public function __construct(
        private readonly ListSubscribersByEvent $listSubscribersByEvent,
        private readonly CreateSubscriber $createSubscriber,
    ) {
    }

    public function index(ListSubscribersByEventRequest $request): Response
    {
        return $this->response(
            contract: $this->listSubscribersByEvent
                ->execute(intval($request->event_id))
        );
    }

    public function store(CreateSubscriberRequest $request): Response
    {
        return $this->response(
            contract: $this->createSubscriber
                ->execute($request),
            status: Response::HTTP_CREATED
        );
    }
}
