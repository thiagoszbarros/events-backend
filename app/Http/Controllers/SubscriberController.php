<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriberRequest;
use App\Services\SubscriberService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SubscriberController extends Controller
{
    public function __construct(
        private SubscriberService $subscriber,
        private Log $log,
    ) {
    }

    public function store(SubscriberRequest $request): Response
    {
        $result = $this->subscriber->create($request);

        return new Response(
            [
                'data' => $result->data,
            ],
            $result->code
        );
    }
}
