<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('notifications')->truncate();

        $userIds = DB::table('useraccount')->pluck('user_id');

        $notifications = [];
        $messages = [
            'A new assignment has been posted in Advanced Database Systems.',
            'Your submission for Web Development Fundamentals has been graded.',
            'Professor Faker posted an announcement.',
            'Someone commented on your post.',
            'You have been added as a coadmin in Software Engineering Capstone.',
        ];

        foreach ($userIds as $userId) {
            for ($i = 0; $i < rand(2, 5); $i++) {
                $notifications[] = [
                    'user_id' => $userId,
                    'message' => fake()->randomElement($messages),
                    'is_read' => fake()->boolean(70), // 70% chance of being read
                    'created_at' => now()->subMinutes(rand(1, 60 * 24)),
                ];
            }
        }

        DB::table('notifications')->insert($notifications);
    }
}
