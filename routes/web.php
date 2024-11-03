<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $college = \App\Models\College::query()->find(1);

    dd($college->lessons);
});
