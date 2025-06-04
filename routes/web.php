<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware(['web','prevent.tenant'])->group(function () {
    Route::get('/register', function () {
        return 'Registration Page';
    });
});