<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
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
    public function render($request, Exception $exception)
    {
        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'Error' => '403, Forbidden',
                'Exception' => strtoupper(substr(md5(rand()), 0, 20)),
                'Descrição' => 'Você não tem autorização para visualizar este conteúdo!',
            ], 403);
        }

        if ($this->isHttpException($exception)) {
            switch ($exception->getStatusCode()) {
                case '404':
                    return response()->json([
                        'Error' => '404, Not Found',
                        'Exception' => strtoupper(substr(md5(rand()), 0, 20)),
                        'Descrição' => 'Página não encontrada!',
                    ], 404);
                    break;
                default:
                    return parent::render($request, $exception);
                    break;
            }
        }

        // this will still show the error if there is any in your code.
        return parent::render($request, $exception);
    }
}
