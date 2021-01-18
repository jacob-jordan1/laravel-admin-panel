<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['message' => 'همچین مسیری وجود ندارد!'], 404);
        }
        if ($exception instanceof AuthorizationException) {
            return response()->json(['message' => 'دسترسی وجود ندارد!'], 403);
        }
        if ($exception instanceof ValidationException) {
            return response()->json([
                'message' => 'داده های داده شده نامعتبر است.',
                'errors' => $exception->errors(),
            ], 422);
        }
        return parent::render($request, $exception);
    }
}
