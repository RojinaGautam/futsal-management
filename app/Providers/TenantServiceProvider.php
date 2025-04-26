<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Facades\Tenancy;
use Illuminate\Support\Facades\DB;

class TenantServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Listen for tenant initialization
        tenancy()->hook('tenant.initialized', function ($tenant) {
            // Define the dynamic database connection for the tenant
            $tenantDatabase = 'tenant_' . $tenant->id; // Assuming tenant ID is used in database naming
     
            // Set the tenant database in the configuration
            config(['database.connections.tenant.database' => $tenantDatabase]);
     
            // Reconnect to the tenant database
            DB::connection('tenant')->reconnect();
        });
    }

    public function register()
    {
        // Register services if needed
    }
}
