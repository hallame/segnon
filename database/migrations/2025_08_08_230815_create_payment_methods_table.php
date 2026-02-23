<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('key')->nullable()->unique(); // ex: mobile_money, bank_transfer, cash, card, cod
            $table->string('type');
            $table->string('name'); // libellé affiché au client
            $table->text('instructions')->nullable(); // HTML/Markdown avec détails paiement
            $table->boolean('active')->default(true);
            $table->unsignedInteger('position')->default(0);
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('payment_methods');
    }
};
