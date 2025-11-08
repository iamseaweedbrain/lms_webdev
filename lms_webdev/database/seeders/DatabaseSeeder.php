<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(AccountSeeder::class);
        $this->call(ClassesSeeder::class);
        $this->call(ClassMemberSeeder::class);
        $this->call(PostSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
