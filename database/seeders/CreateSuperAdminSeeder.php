<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Create Super Admin User
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password123')
        ]);

        // Create Super Admin Role if it doesn't exist
        $role = Role::firstOrCreate(['name' => 'super-admin']);

        // Assign Role to User
        $superAdmin->assignRole('super-admin');
    }
}