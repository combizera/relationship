<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $post = \App\Models\Post::with('comments')->find(1);
    dd($post->comments);
    //return view('welcome');
});
