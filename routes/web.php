<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware('web')->group(function () {
    Route::get('/', fn () => 'Central Homepage'); // ⬅️ this is for localhost:8000
});

