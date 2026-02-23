<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();
            $table->tinyInteger('status')->default(1);
            $table->text('description');
            $table->dateTime('start_date');
            $table->decimal('price', 30, 2)->nullable();
            $table->dateTime('end_date');
            $table->string('location')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('video_url')->nullable();
            $table->string('info')->nullable();
            $table->foreignId('language_id')->default(1)->constrained('languages')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('map_url')->nullable();
            $table->text('map_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('events');
    }
};
