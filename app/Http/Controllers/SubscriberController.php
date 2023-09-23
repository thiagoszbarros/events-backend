<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriberRequest;
use App\Interfaces\EventsSubscribersRepositoryInterface;
use App\Services\SubscriberService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SubscriberController extends Controller
{
    public function __construct(
        private SubscriberService $subscriber,
        private EventsSubscribersRepositoryInterface $eventSubscriber,
        private Log $log,
    ) {
    }

    public function store(SubscriberRequest $request): Response
    {
        try {
            return new Response(
                [
                    'data' => $this->subscriber->create($request),
                ],
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            $this->log::info($e);

            return new Response(
                [
                    'data' => 'Não foi possível realizar a subscrição.',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
