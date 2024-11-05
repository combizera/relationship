<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => 'https://randomuser.me/api/portraits/'. $this->faker->randomElement(['women/', 'men/']) . rand(0, 50) . '.jpg',
            'model_type' => $this->faker->randomElement([Category::class, Post::class]),
            'model_id' => $this->faker->unique()->numberBetween(1, 30),
        ];
    }
}
