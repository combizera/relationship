<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Avatar;
use App\Models\College;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Order;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Student;
use App\Models\StudentCourse;
use App\Models\Tag;
use App\Models\Teacher;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(30)->create();
        Avatar::factory(10)->create();
        Post::factory(50)->create();
        Comment::factory(100)->create();
        Tag::factory(50)->create();
        PostTag::factory(20)->create();
        Student::factory(50)->create();
        Course::factory(10)->create();
        StudentCourse::factory(50)->create();
        Order::factory(50)->create();
        Address::factory(50)->create();
        College::factory(3)->create();
        Teacher::factory(25)->create();
        Lesson::factory(120)->create();
    }
}
