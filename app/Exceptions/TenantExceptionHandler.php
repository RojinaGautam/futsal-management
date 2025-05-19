<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler;
use Stancl\Tenancy\Contracts\TenantCouldNotBeIdentifiedException;
use Throwable;

class TenantExceptionHandler extends Handler
{
    public function register(): void
    {
        $this->renderable(function (TenantCouldNotBeIdentifiedException $e) {
            return response()->view('resources/views/errors/404.blade.php', [], 404);
        });
    }
}