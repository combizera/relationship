<?php

namespace Database\Seeders;

use App\Models\Avatar;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Avatar::factory(10)->create();
        Post::factory(50)->create();
        Comment::factory(100)->create();
    }
}
