<?php

namespace App\Providers;

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        // Central (main) routes - these will be accessible at localhost
        Route::middleware(['web'])
            ->group(base_path('routes/web.php'));

        // Tenant routes - only accessible on subdomains, not on localhost
        Route::middleware([
            'web',
            InitializeTenancyByDomain::class,
            PreventAccessFromCentralDomains::class,
        ])->group(function () {
            Route::group([], base_path('routes/tenant.php'));
        });
    }
}