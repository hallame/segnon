<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete(); // optionnel
            $table->string('name'); // ex: Standard, VIP
            $table->string('sku')->nullable();
            
            $table->decimal('price', 32, 2)->default(0);
            $table->integer('quantity')->nullable(); // null = illimité
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // ex: ["Accès backstage", "Boisson offerte"]
            $table->boolean('is_refundable')->default(false);
            $table->boolean('is_active')->default(true);
            $table->dateTime('sales_start')->nullable();
            $table->dateTime('sales_end')->nullable();
            $table->integer('max_per_order')->nullable();
            $table->json('metadata')->nullable(); // extension future (seats, zone, free text)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_types');
    }
};
