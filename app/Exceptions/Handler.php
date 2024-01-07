<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception): Response
    {
        Log::info($exception);

        if (env('APP_ENV') === 'local' || env('APP_ENV') === 'testing') {
            return new Response(
                [
                    'message' => $exception->getMessage(),
                    'data' => null,
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        // @codeCoverageIgnoreStart
        return new Response(
            [
                'message' => 'Opa! Algo deu errado. Tente novamente mais tarde.',
                'data' => null,
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
        // @codeCoverageIgnoreEnd
    }
}
