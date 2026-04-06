<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    private static ?array $userIds = null;
    private static ?array $articleIds = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lazy load IDs cache (static to persist across all instances)
        if (self::$userIds === null) {
            self::$userIds = \App\Models\User::pluck('id')->toArray();
        }
        if (self::$articleIds === null) {
            self::$articleIds = \App\Models\Article::pluck('id')->toArray();
        }

        return [
            'comment' => fake()->sentence(),
            'user_id' => self::$userIds[array_rand(self::$userIds)],
            'article_id' => self::$articleIds[array_rand(self::$articleIds)],
        ];
    }
}
