<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

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

    private $customExceptions = [
        AppPricesNotFoundException::class,
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
        if ($exception instanceof ValidationException) {
            $fail = key($exception->validator->failed());

            switch ($fail){
                case 'username':
                case 'phone':
                case 'gender':
                    $code=422;
                    break;
                default:
                    $code = 422;
            }

            return response()->json([],$code,[],JSON_FORCE_OBJECT);
        }
        foreach ($this->customExceptions as $custom) {
            if ($exception instanceof $custom && method_exists($custom, 'render')) {
                return parent::render($request, $exception);
            }
        }
        return parent::render($request, $exception);
    }
}
