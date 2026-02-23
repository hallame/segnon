<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('sku')->unique()->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 32, 2)->default(0);
            $table->decimal('old_price', 32, 2)->nullable();
            $table->string('currency')->default('XOF');
            $table->integer('stock')->default(0);
            $table->string('type')->default('simple');
            $table->decimal('weight', 20, 2)->nullable();
            $table->string('unit')->nullable(); // ex: kg, cm, m
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('video')->nullable();
            $table->string('video_url')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('products');
    }
};
