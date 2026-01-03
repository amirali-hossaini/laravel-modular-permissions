<?php

namespace Database\Factories;

use App\Modules\Blog\Models\Post;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->word(),
            'slug' => fake()->unique()->slug(),
            'body' => fake()->sentence(),
        ];
    }
}
