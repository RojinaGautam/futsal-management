<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call(RoleAndPermissionSeeder::class);
        $this->call(CreateSuperAdminSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
