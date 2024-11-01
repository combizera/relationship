<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_tags', function (Blueprint $table) {
            $table->id();
            $table
                ->bigInteger('post_id')
                ->unsigned();
            $table
                ->foreign('post_id')
                ->references('id')
                ->on('posts');
            $table
                ->bigInteger('tag_id')
                ->unsigned();
            $table
                ->foreign('tag_id')
                ->references('id')
                ->on('tags');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tags');
    }
};
