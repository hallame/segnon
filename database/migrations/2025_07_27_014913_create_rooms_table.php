<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('slug')->nullable()->unique();
            $table->text('description')->nullable();
            $table->integer('capacity')->nullable();
            $table->decimal('price', 20, 8)->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->string('info')->nullable();
            $table->string('address')->nullable();
            $table->string('video')->nullable();
            $table->string('video_url')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();

            $table->index('hotel_id');
            $table->index('created_at');
        });
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('rooms');
    }
};
