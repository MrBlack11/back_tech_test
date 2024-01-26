<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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

        $this->renderable(function (ValidationApiException $exception) {
            return response()->json([
                'message' => 'Something went wrong',
                'errors' => json_decode($exception->getMessage())
            ], $exception->getCode());
        });

        $this->renderable(function (Throwable $exception) {
            return response()->json(
                ['message' => $exception->getMessage()],
                $exception->getCode()
            );
        });
    }
}
