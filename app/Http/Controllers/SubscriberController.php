<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\SubscriberRequest;
use App\Interfaces\SubscriberInterface;
use Illuminate\Support\Facades\Log;

class SubscriberController extends Controller
{
    public function __construct(
        private SubscriberInterface $subscriber,
        private Log $log
    ) {
    }

    public function index(PaginationRequest $request)
    {
        try {
            return new Response(
                [
                    'data' => $this->subscriber->index($request->offset)
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            $this->log::info($e);
            return new Response(
                [
                    'data' => []
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    public function store(SubscriberRequest $request)
    {
        try {
            $this->subscriber->store($request);
            return new Response(
                [
                    'data' => 'Subscrição realizada com sucesso.',
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
