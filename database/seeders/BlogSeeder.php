<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks for faster seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data
        \App\Models\Comment::truncate();
        \App\Models\Article::truncate();
        \App\Models\Tag::truncate();
        \App\Models\User::truncate();

        // Create data with better performance
        \App\Models\User::factory(1000)->create();  // Reduced from 1000
        \App\Models\Tag::factory(1000)->create();
        \App\Models\Article::factory(1000)->create();  // Reduced from 5000
        \App\Models\Comment::factory(1000)->create();  // Reduced from 10000

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Database seeded successfully!');
    }
}
