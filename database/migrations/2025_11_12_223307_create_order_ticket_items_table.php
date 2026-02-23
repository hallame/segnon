<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('order_ticket_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_ticket_id')->constrained('order_tickets')->cascadeOnDelete();
            $table->foreignId('ticket_type_id')->constrained('ticket_types')->cascadeOnDelete();

            $table->string('ticket_type_name'); // snapshot
            $table->decimal('unit_price', 30, 2)->default(0);
            $table->integer('qty')->default(1);
            $table->decimal('total_price', 30, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_ticket_items');
    }
};
