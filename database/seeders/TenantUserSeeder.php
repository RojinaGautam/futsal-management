<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class TenantUserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Seed fake users for the tenant
        foreach (range(1, 3) as $index) {  // Adjust the range as needed
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'), // You can hash passwords as needed
            ]);
        }

        $this->command->info("Fake users seeded for tenant.");
    }
}
