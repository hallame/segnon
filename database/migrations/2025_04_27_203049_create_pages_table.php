<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('type')->nullable();
            $table->string('slug')->unique()->nullable();

            $table->text('content')->nullable();
            $table->string('excerpt')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('image')->nullable();
            $table->string('banner')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video')->nullable();
            $table->string('meta_title')->nullable(); // SEO
            $table->string('info')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable(); // SEO
            $table->unsignedBigInteger('parent_id')->nullable(); // Page parente pour les sous-pages
            $table->foreign('parent_id')->references('id')->on('pages')->onDelete('cascade'); // Lien vers une page parente
            $table->timestamp('published_at')->nullable(); // Date de publication
            $table->foreignId('language_id')->default(1)->constrained('languages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
