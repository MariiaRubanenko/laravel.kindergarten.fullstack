<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\QueryException;

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

//     public function render($request, Throwable $e)
// {
//     if ($e instanceof QueryException && $e->errorInfo[1] === 1062) {
//         return response()->json(['error' => 'A lesson with the same day, action, and group already exists.'], 400);
//     }

//     return parent::render($request, $e);
// }
    
}
