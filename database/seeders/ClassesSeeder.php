<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classes')->truncate();

        $teacherId = DB::table('useraccount')->where('email', 'teacher@example.com')->value('user_id');

        DB::table('classes')->insert([
            [
                'creator_id' => $teacherId,
                'classname' => 'Advanced Database Systems',
                'description' => 'In-depth study of relational, NoSQL, and graph databases.',
                'code' => Str::upper(Str::random(6)),
                'color'=> 'pink',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'creator_id' => $teacherId,
                'classname' => 'Web Development Fundamentals',
                'description' => 'Introduction to HTML, CSS, JavaScript, and Laravel.',
                'code' => Str::upper(Str::random(6)),
                'color'=> 'blue',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'creator_id' => $teacherId,
                'classname' => 'Software Engineering Capstone',
                'description' => 'Project-based course covering the full SDLC.',
                'code' => Str::upper(Str::random(6)),
                'color'=> 'yellow',
                'created_at' => now()->subWeek(),
                'updated_at' => now()->subWeek(),
            ],
            [
                'creator_id' => $teacherId,
                'classname' => 'Software Engineering Capstone',
                'description' => 'Project-based course covering the full SDLC.',
                'code' => Str::upper(Str::random(6)),
                'color'=> 'purple',
                'created_at' => now()->subWeek(),
                'updated_at' => now()->subWeek(),
            ],
            [
                'creator_id' => $teacherId,
                'classname' => 'Software Engineering Capstone',
                'description' => 'Project-based course covering the full SDLC.',
                'code' => Str::upper(Str::random(6)),
                'color'=> 'pink',
                'created_at' => now()->subWeek(),
                'updated_at' => now()->subWeek(),
            ],
            [
                'creator_id' => $teacherId,
                'classname' => 'Software Engineering Capstone',
                'description' => 'Project-based course covering the full SDLC.',
                'code' => Str::upper(Str::random(6)),
                'color'=> 'yellow',
                'created_at' => now()->subWeek(),
                'updated_at' => now()->subWeek(),
            ],
        ]);
    }
}
