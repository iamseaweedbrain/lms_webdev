<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('useraccount')->truncate();

        // Teacher User
        DB::table('useraccount')->insert([
            'user_id' => uniqid('user_'),
            'firstname' => 'Professor',
            'lastname' => 'Faker',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'avatar' => 'avatars/active-cat.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Student Users
        for ($i = 1; $i <= 5; $i++) {
            DB::table('useraccount')->insert([
                'user_id' => uniqid('user_'),
                'firstname' => fake()->firstName(),
                'lastname' => fake()->lastName(),
                'email' => "student{$i}@example.com",
                'password' => Hash::make('password'),
                'avatar' => 'avatars/active-cat.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
