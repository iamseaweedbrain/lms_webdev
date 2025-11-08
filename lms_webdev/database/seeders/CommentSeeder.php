<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('comments')->truncate();

        $postIds = DB::table('posts')->pluck('post_id');
        $userIds = DB::table('useraccount')->pluck('user_id');

        $comments = [];
        foreach ($postIds as $postId) {
            // Add 1 to 4 comments per post
            for ($i = 0; $i < rand(1, 4); $i++) {
                $comments[] = [
                    'post_id' => $postId,
                    'user_id' => fake()->randomElement($userIds),
                    'comment_text' => fake()->sentence(rand(5, 15)),
                    'created_at' => now()->subMinutes(rand(1, 60 * 24 * 7)),
                ];
            }
        }

        DB::table('comments')->insert($comments);
    }
}
