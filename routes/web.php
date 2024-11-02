<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $student = \App\Models\Student::with('courses')->find(21);
    //$student->posts()->attach(1);
    dd($student);
    //return view('welcome');
});
