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
    }

    public function render($request, Throwable $e)
    {

        if (! $request->is('api/*')) {
            return parent::render($request, $e);
        }

        $data = null;
        if (method_exists($e, 'errors')) {
            foreach ($e->errors() ?? [] as $key => $value) {
                $data[$key] = $value[0];
            }
        }

        $message = $e->getMessage();
        $statusCode = 400;

        if (method_exists($e, 'getStatusCode')) {

            $statusCode = $e->getStatusCode();

            if ($statusCode == 404) {
                $message = '404 Not found';
            }

            if ($statusCode == 403) {
                $message = '403 Forbidden';
            }

            if ($statusCode == 401) {
                $message = '401 Unauthorized';
            }

            if ($statusCode == 405) {
                $message = '405 Method not allowed';
            }

            if ($statusCode == 422) {
                $message = '422 Unprocessable entity';
            }

            if ($statusCode == 500) {
                $message = '500 Internal server error';
            }

            if ($statusCode == 503) {
                $message = '503 Service unavailable';
            }

            if ($statusCode == 429) {
                $message = '429 Too many requests';
            }

            if ($statusCode == 419) {
                $message = '419 Page expired';
            }

            if ($statusCode == 400) {
                $message = '400 Bad request';
            }

            if ($statusCode == 408) {
                $message = '408 Request timeout';
            }

            if ($statusCode == 409) {
                $message = '409 Conflict';
            }

            if ($statusCode == 410) {
                $message = '410 Gone';
            }

            if ($statusCode == 411) {
                $message = '411 Length required';
            }

            if ($statusCode == 412) {
                $message = '412 Precondition failed';
            }

            if ($statusCode == 413) {
                $message = '413 Payload too large';
            }

            if ($statusCode == 414) {
                $message = '414 URI too long';
            }

            if ($statusCode == 415) {
                $message = '415 Unsupported media type';
            }

            if ($statusCode == 416) {
                $message = '416 Range not satisfiable';
            }

            if ($statusCode == 417) {
                $message = '417 Expectation failed';
            }

            if ($statusCode == 418) {
                $message = '418 I\'m a teapot';
            }

            if ($statusCode == 421) {
                $message = '421 Misdirected request';
            }
        }

        if ($message == 'Unauthenticated.') {
            $statusCode = 401;
        }

        if ($message == 'Invalid ability provided.') {
            $statusCode = 403;
            $message = 'You don\'t have permission to access this resource';
        }

        if (str_contains($message, 'No query results')) {
            $message = 'Resource Not found';
            $statusCode = 404;
        }

        return error($message, $statusCode, $data);
    }
}
