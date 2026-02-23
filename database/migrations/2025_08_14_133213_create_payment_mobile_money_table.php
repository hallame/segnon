<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('payment_mobile_money', function (Blueprint $table) {
            $table->id();

            $table->foreignId('payment_method_id')->constrained()->cascadeOnDelete()->unique();
            $table->string('operator'); // orange, mtn, moov, wave, free...
            $table->string('wallet_number');
            $table->string('wallet_name')->nullable();
            $table->string('qr')->nullable(); // chemin/URL
            $table->string('reference_hint')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('payment_mobile_money');
    }
};
