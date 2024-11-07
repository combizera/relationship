<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $book = \App\Models\Book::query()->find(1);

    dd($book, $book->commentable);
});
