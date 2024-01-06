<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriberRequest;
use App\Http\Requests\SubscribersRequest;
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

    public function index(SubscribersRequest $request): Response
    {
        $result = $this->listSubscribersByEvent
            ->execute($request->event_id);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }

    public function store(SubscriberRequest $request): Response
    {
        $result = $this->createSubscriber
            ->execute($request);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }
}
