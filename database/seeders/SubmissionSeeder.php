<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('submissions')->truncate();

        // Get assignment posts
        $assignmentPosts = DB::table('posts')
            ->where('post_type', 'assignment')
            ->get();

        $studentIds = DB::table('useraccount')->where('email', 'like', 'student%')->pluck('user_id');
        $teacherId = DB::table('useraccount')->where('email', 'teacher@example.com')->value('user_id');

        $submissions = [];
        foreach ($assignmentPosts as $post) {
            foreach ($studentIds as $studentId) {
                if (rand(1, 10) <= 8) {
                    $isGraded = rand(0, 1);
                    $max_score = 100;
                    $score = $isGraded ? fake()->numberBetween(60, $max_score) : null;
                    $gradedBy = $isGraded ? $teacherId : null;
                    $gradedAt = $isGraded ? now() : null;

                    $submissions[] = [
                        'post_id' => $post->post_id,
                        'user_id' => $studentId,
                        'file_type' => fake()->randomElement(['image', 'file', 'link']),
                        'file_path' => "/submissions/{$post->post_id}/{$studentId}/" . fake()->slug() . '.zip',
                        'submitted_at' => now()->subDays(rand(1, 7)),
                        'score' => $score,
                        'max_score' => $max_score,
                        'feedback' => $isGraded ? fake()->optional(0.8)->sentence(5) : null,
                        'graded_by' => $gradedBy,
                        'graded_at' => $gradedAt,
                    ];
                }
            }
        }

        DB::table('submissions')->insert($submissions);
    }
}
