<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;

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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(\Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, \Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException &&
        $request->wantsJson())
        {
            return response()->json([
                'data' => 'Resource not found'
            ], Response::HTTP_NOT_FOUND);
        }

        if($exception instanceof AuthenticationException) 
        {
            return response()->json([
                'data' => 'Unauthenticated'
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        return parent::render($request, $exception);
    }
}
