<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lazy load user IDs cache
        if (!isset($this->userIds)) {
            $this->userIds = \App\Models\User::pluck('id')->toArray();
        }

        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraph(),
            'user_id' => $this->userIds[array_rand($this->userIds)],
        ];
    }

    private ?array $userIds = null;
}
