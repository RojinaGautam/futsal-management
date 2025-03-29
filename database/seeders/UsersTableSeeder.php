<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create admin users
        $adminUsers = [
            [
                'name' => 'Yaman Gurung',
                'email' => 'yamangurung@dstudiosnepal.com',
                'password' => bcrypt('Ygurung@321'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Ram Shrestha',
                'email' => 'ramshrestha@dstudiosnepal.com',
                'password' => bcrypt('Rshrestha@321'),
                'remember_token' => Str::random(10),
            ]
        ];

        // Create staff users
        $staffUsers = [
            [
                'name' => 'Staff One',
                'email' => 'staff1@dstudiosnepal.com',
                'password' => bcrypt('Staff@123'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Staff Two',
                'email' => 'staff2@dstudiosnepal.com',
                'password' => bcrypt('Staff@123'),
                'remember_token' => Str::random(10),
            ]
        ];

        // Create and assign roles
        foreach ($adminUsers as $adminData) {
            $admin = User::create($adminData);
            $admin->assignRole('admin');
        }

        foreach ($staffUsers as $staffData) {
            $staff = User::create($staffData);
            $staff->assignRole('staff');
        }
    }
}