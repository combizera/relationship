<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        $slug = Str::slug($title);

        return [
            'title' => $title,
            'slug' => $slug,
            'url' => 'https://youtu.be/' . $slug,
        ];
    }
}
