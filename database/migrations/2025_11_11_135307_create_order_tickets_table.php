<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('order_tickets', function (Blueprint $table) {
            $table->id();

            $table->string('reference')->unique();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
            $table->string('moneroo_transaction_id')->nullable();

            // client snapshot
            $table->string('customer_firstname');
            $table->string('customer_lastname');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();

            // montants
            $table->decimal('subtotal', 30, 2)->default(0);
            $table->decimal('discount', 30, 2)->default(0);
            $table->decimal('tax', 30, 2)->default(0);
            $table->decimal('total', 30, 2)->default(0);
            $table->string('currency', 8)->default('GNF');

            // statut de la commande billets
            // draft -> awaiting_payment/under_review -> paid | expired | cancelled
            $table->string('status')->default('draft')->index();
            $table->timestamp('expires_at')->nullable(); // pour la réservation à durée limitée
            $table->timestamps();

            // Le ticket physique
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('order_tickets');
    }
};
