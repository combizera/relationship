<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Avatar>
 */
class AvatarFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => 'https://randomuser.me/api/portraits/'. $this->faker->randomElement(['women/', 'men/']) . rand(0, 50) . '.jpg',
            'user_id' => $this->faker->unique()->numberBetween(1, 10),
        ];
    }
}
