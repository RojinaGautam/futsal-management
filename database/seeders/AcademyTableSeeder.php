<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AcademyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 15; $i++) {
            DB::table('academy')->insert([
                'student_name' => 'Student ' . $i,
                'monthly_price' => rand(500, 2000), // Random price between 500 and 2000
                'age' => rand(10, 30), // Random age between 10 and 30
                'phone_no' => '98765' . rand(10000, 99999), // Random phone number
                'email' => 'student' . $i . '@example.com', // Unique email
                'total_due_left' => rand(1000, 5000), // Random due amount between 1000 and 5000
                'joined_date' => now()->subDays(rand(0, 365)), // Random joined date within the past year
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
