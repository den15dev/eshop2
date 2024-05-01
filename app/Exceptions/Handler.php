<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
            Log::channel('events')->info('<span style="color: #e2347a;">An error occurred!</span>' . "\n" . '<span style="color: #969696;">' . $e->getMessage() . "\n" . $e->getFile() . ':' . $e->getLine() . "\n" . url()->current() . '</span>');
        });
    }
}
