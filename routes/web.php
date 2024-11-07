<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $tags = \App\Models\Tag::query()->find(1);

    dd($tags);
});
