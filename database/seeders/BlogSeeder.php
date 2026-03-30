<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory(1000)->create();
        \App\Models\Tag::factory(100)->create();
        \App\Models\Article::factory(5000)->create();
        \App\Models\Comment::factory(10000)->create();
    }
}
