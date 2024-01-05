<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriberRequest;
use App\Http\Requests\SubscribersRequest;
use App\Services\SubscriberService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SubscriberController extends Controller
{
    public function __construct(
        private SubscriberService $subscriberService,
        private Log $log,
    ) {
    }

    public function index(SubscribersRequest $request): Response
    {
        $result = $this->subscriberService
            ->listByEvent($request->event_id);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }

    public function store(SubscriberRequest $request): Response
    {
        $result = $this->subscriberService->create($request);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }
}
