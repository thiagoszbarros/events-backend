<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Contract;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function response(
        Contract $contract,
        ?int $status = Response::HTTP_OK
    ): Response {
        return $contract->isValid() ?
            $this->ok(
                data: $contract->getData(),
                message: $contract->getMessage(),
                status: $status
            ) :
            $this->fail(
                data: null,
                message: $contract->getError()
            );
    }

    private function ok(
        mixed $data,
        string $message,
        ?int $status = Response::HTTP_OK
    ): Response {
        return new Response(
            content: [
                'message' => $message,
                'data' => $data
            ],
            status: $status
        );
    }

    private function fail(
        mixed $data,
        string $message,
        ?int $status = Response::HTTP_BAD_REQUEST
    ): Response {
        return new Response(
            content: [
                'message' => $message,
                'data' => $data
            ],
            status: $status,
        );
    }
}
