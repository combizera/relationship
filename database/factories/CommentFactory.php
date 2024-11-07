<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph(4),
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'commentable_type' => $this->faker->randomElement([Post::class, Book::class, Video::class]),
            'commentable_id' => $this->faker->randomElement([
                Post::query()->inRandomOrder()->first()->id,
                Book::query()->inRandomOrder()->first()->id,
                Video::query()->inRandomOrder()->first()->id
            ]),
        ];
    }
}
