<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Facades\Tenancy;

class TenantModel extends Model
{
    /**
     * Boot method to add global tenant scope for each model
     */
    protected static function booted()
    {
        static::addGlobalScope('tenant', function ($query) {
            // Get tenant's database connection
            $tenantDatabase = 'tenant_' . tenant('id'); // Assuming tenant() is the helper to get current tenant
            
            // Dynamically set the connection for this model
            $query->useConnection($tenantDatabase);
        });
    }
}
