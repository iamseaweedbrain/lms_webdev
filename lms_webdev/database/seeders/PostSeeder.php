<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->truncate();

        $classIds = DB::table('classes')->pluck('code');
        $teacherId = DB::table('useraccount')->where('email', 'teacher@example.com')->value('user_id');
        $teacherAvatar = DB::table('useraccount')->where('email', 'teacher@example.com')->value('avatar');

        $posts = [];
        foreach ($classIds as $classId) {
            $posts[] = [
                'code' => $classId,
                'user_id' => $teacherId,
                'post_title' => 'Announcement',
                'post_type' => 'announcement',
                'content' => fake()->sentence(8) . '. Remember to check the course outline!',
                'due_date' => null, 
                'created_at' => now()->subHours(rand(1, 24)),
            ];

            $posts[] = [
                'code' => $classId,
                'user_id' => $teacherId,
                'post_title' => 'Material',
                'post_type' => 'material',
                'content' => 'Lecture slides for the first module: ' . fake()->paragraph(2),
                'due_date' => null, 
                'created_at' => now()->subDays(rand(1, 7)),
            ];

            $posts[] = [
                'code' => $classId,
                'user_id' => $teacherId,
                'post_title' => 'Assignment',
                'post_type' => 'assignment',
                'content' => 'Term Project: Create a full-stack web application based on the principles discussed in class.',
                'due_date' => now()->addDays(rand(7, 30)),
                'created_at' => now()->subDays(rand(7, 14)),
            ];
        }

        DB::table('posts')->insert($posts);
    }
}
