<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('type')->nullable();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onDelete('cascade');
            $table->foreignId('language_id')->default(1)->constrained('languages')->onDelete('cascade');
            $table->string('page')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('image')->nullable();
            $table->integer('position')->default(0);
            $table->string('link')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
