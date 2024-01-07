<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Subscribers\CreateSubscriberRequest;
use App\Http\Requests\Subscribers\ListSubscribersByEventRequest;
use App\Services\Subscribers\DoSubscription;
use App\Services\Subscribers\ListSubscribersByEvent;
use App\ValueObjects\Subscribers\DoSubscriptionParams;
use Illuminate\Http\Response;

class SubscriberController extends Controller
{
    public function __construct(
        private readonly ListSubscribersByEvent $listSubscribersByEvent,
        private readonly DoSubscription $doSubscription,
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
            contract: $this->doSubscription
                ->execute(new DoSubscriptionParams(
                    intval($request->event_id),
                    $request->email,
                    $request->name,
                    $request->cpf
                )),
            status: Response::HTTP_CREATED
        );
    }
}
