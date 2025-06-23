<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->longText("description");
            $table->string("slug")->unique()->nullable();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->longText("description");
            $table->string("slug")->unique()->nullable();
            $table->timestamps();
        });

        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->longText("description");
            $table->string("image")->nullable();
            $table->string("author");
            $table->string("slug")->unique()->nullable();
            $table->string("category_id");
            $table->timestamps();
        });
        
        Schema::create('blog_tag', function (Blueprint $table) {
            $table->foreignId('blog_id')
                ->constrained('blogs')
                ->onDelete('cascade');
        
            $table->foreignId('tag_id')
                ->constrained('tags')
                ->onDelete('cascade');
        
            $table->primary(['blog_id', 'tag_id']); 
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('blogs');
    }
};
