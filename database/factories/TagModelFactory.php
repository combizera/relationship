<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TagModel>
 */
class TagModelFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tag_id' => $this->faker->numberBetween(1, 50),
            'taggable_type' =>$this->faker->randomElement([Post::class, Video::class]),
            'taggable_id' => $this->faker->numberBetween(1, 50),
        ];
    }
}
