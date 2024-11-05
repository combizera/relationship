<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $image = \App\Models\Image::query()->find(10);

    dd($image->imageable);
});
