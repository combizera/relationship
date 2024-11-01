<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_courses', function (Blueprint $table) {
            $table->id();
            $table
                ->bigInteger('student_id')
                ->unsigned();
            $table
                ->foreign('student_id')
                ->references('id')
                ->on('students');
            $table
                ->bigInteger('course_id')
                ->unsigned();
            $table
                ->foreign('course_id')
                ->references('id')
                ->on('courses');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_courses');
    }
};
