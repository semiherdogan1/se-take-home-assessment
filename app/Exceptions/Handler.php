<?php

namespace App\Exceptions;

use App\Classes\ResponseCodes;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
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
        'current_password',
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

        $this->renderable(function (Throwable $e) {
            if (request()->is('api/*')) {
                //
                logger()->error('An error occurred', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);

                $responseMeta = ResponseCodes::ERROR;
                if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                    $responseMeta = ResponseCodes::UNAUTHENTICATED;
                }

                return responder()
                    ->setHttpStatuscode(Response::HTTP_BAD_REQUEST)
                    ->setResponseMeta($responseMeta)
                    ->send();
            }
        });
    }
}
