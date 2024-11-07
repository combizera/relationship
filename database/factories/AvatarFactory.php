<?php

namespace Database\Factories;

use App\Models\User;
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
            'user_id' => User::query()->inRandomOrder()->first()->id,
        ];
    }
}