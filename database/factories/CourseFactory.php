<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $courseName = $this->faker->sentence(3);
        return [
            'name' => $courseName,
            'slug' => Str::slug($courseName),
            'description' => $this->faker->sentence(10),
        ];
    }
}
