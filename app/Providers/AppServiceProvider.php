<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\SetupTenant;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register commands when running in console
        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupTenant::class,
            ]);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}