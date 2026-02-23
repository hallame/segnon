<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_type_id')->constrained('ticket_types')->cascadeOnDelete();
            $table->string('qr_code')->nullable()->unique();
            $table->foreignId('order_ticket_id')->nullable()->constrained('order_tickets')->nullOnDelete();
            $table->timestamp('reserved_at')->nullable();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->enum('status', [
                'available',    // non encore vendu
                'reserved',     // réservé mais pas payé
                'sold',         // vendu
                'cancelled',    // annulé
                'used',         // utilisé / check-in
                'expired',      // expiré (date passée sans utilisation)
                'refunded'      // remboursé
            ])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('tickets');
    }
};
