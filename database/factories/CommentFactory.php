<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment' => fake()->sentence(),
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'article_id' => \App\Models\Article::inRandomOrder()->first()->id,
        ];
    }
}
