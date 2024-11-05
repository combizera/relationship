<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            //$table
            //    ->integer('post_id')
            //    ->unsigned();
            //$table
            //    ->foreign('post_id')
            //    ->references('id')
            //    ->on('posts')
            //    ->onDelete('cascade');
            $table->morphs('model');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
