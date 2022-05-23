<?php

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        CustomException::class
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
            if ($this->shouldReport($e) && app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request   $request
     * @param Throwable $e
     *
     * @SuppressWarnings("unused")
     *
     * @return Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        if (env('APP_DEBUG')) {
            Log::debug($e);
        }

        switch (true) {
            case $e instanceof HttpException:
                $result = $this->httpException($e);
                break;
            case $e instanceof CustomValidationException:
                $result = $this->validationException($e);
                break;
            case $e instanceof AuthorizationException:
                if (!empty($e->getCode()) && $e->getCode() == config('auth.error-code.salon_unactive')) {
                    return $this->error($e->getCode(), trans('auth.salon_unactive'), Response::HTTP_UNAUTHORIZED);
                }

                $result = $this->errorException($e, Response::HTTP_FORBIDDEN);
                break;
            case $e instanceof CustomException:
                $result = $this->error($e->getErrorCode(), $e->getMessage(), $e->getCode());
                break;
            case $e instanceof ModelNotFoundException:
                $result = $this->error(
                    config('common.error-code.not_found'),
                    trans('common.not_found'),
                    Response::HTTP_NOT_FOUND
                );
                break;
            default:
                $result = $this->errorException($e);
        }

        return $result;
    }
}
