<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;

class SetupTenant extends Command
{
    protected $signature = 'tenant:setup {id}';
    protected $description = 'Creates a new tenant, domain, database and runs all migrations';

    public function handle()
    {
        $id = $this->argument('id');
    
        $tenant = Tenant::firstOrCreate(['id' => $id]);
    
        $domain = "{$id}.localhost"; // 🔥 manually set domain
    
        // Step 1: Create tenant database
        $this->info("Creating database for tenant: $id");
        try {
            DB::statement("CREATE DATABASE IF NOT EXISTS tenant_{$tenant->id}");
        } catch (\Throwable $e) {
            $this->error("Failed to create database: " . $e->getMessage());
            return Command::FAILURE;
        }
    
        // Step 2: Create domain
        DB::table('domains')->updateOrInsert(
            ['domain' => $domain],
            ['tenant_id' => $tenant->id]
        );
    
        // Step 3: Initialize tenancy
        $this->info("Initializing tenant: {$tenant->id}");
        tenancy()->initialize($tenant);
    
        // Step 4: Set tenant DB connection dynamically
        $tenantDb = 'tenant_' . $tenant->id;
        config(['database.connections.tenant.database' => $tenantDb]);
        DB::connection('tenant')->reconnect();
    
        // Step 5: Run main migrations
        $this->info("Running main migrations for tenant");
        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path' => 'database/migrations',
            '--force' => true,
        ]);
        $this->line(Artisan::output());
    
        // Step 6: Run tenant-specific migrations
        $this->info("Running tenant-specific migrations");
        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path' => 'database/migrations/tenant',
            '--force' => true,
        ]);
        $this->line(Artisan::output());

        $this->info("Seeding fake users for tenant");
        
        Artisan::call('db:seed', [
            '--class' => 'TenantUserSeeder', // Make sure the seeder is created correctly
            '--database' => 'tenant', // Specify tenant's database
            '--force' => true,  // Use --force to allow seeding in production
        ]);
        $this->line(Artisan::output());
    
        tenancy()->end();
        $this->info("Tenant {$tenant->id} setup complete ✅");
    
        return Command::SUCCESS;
    }
}
