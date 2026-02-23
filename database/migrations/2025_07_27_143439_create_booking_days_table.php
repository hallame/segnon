<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('booking_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            // Polymorphisme : identifie la ressource réservée
            $table->string('bookable_type');
            $table->unsignedBigInteger('bookable_id');
            // Jour réservé (1 ligne = 1 jour)
            $table->date('day');
            // Index rapides pour le check dispo
            $table->index(['bookable_type', 'bookable_id', 'day'], 'booking_days_dispo_idx');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('booking_days');
    }
};
