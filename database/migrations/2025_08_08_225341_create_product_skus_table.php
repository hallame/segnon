<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('product_skus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();
            $table->string('sku')->unique();
            $table->json('attributes')->nullable(); // ex: {"color":"Noir","size":"M"}
            $table->decimal('price', 32, 2)->default(0);
            $table->decimal('old_price', 32, 2)->nullable();
            $table->string('currency')->default('XOF');
            $table->integer('stock')->default(0);
            $table->decimal('weight', 20, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('unit')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('product_skus');
    }
};
