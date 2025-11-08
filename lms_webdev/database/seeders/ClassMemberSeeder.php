<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ClassMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classmembers')->truncate();

        $allClassIds = DB::table('classes')->pluck('code');
        // Fetch all student user IDs
        $studentIds = DB::table('useraccount')->where('email', 'like', 'student%')->pluck('user_id');

        $data = [];
        foreach ($allClassIds as $classId) {
            foreach ($studentIds as $userId) {
                $data[] = [
                    'code' => $classId,
                    'user_id' => $userId,
                    'role' => (rand(1, 10) === 1) ? 'coadmin' : 'member',
                    'joined_at' => now()->subDays(rand(1, 30)),
                ];
            }
        }

        DB::table('classmembers')->insert($data);
    }
}
