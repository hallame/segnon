<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('reference')->unique(); // ex: ZALY-202508-AB12CD
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
            $table->string('moneroo_transaction_id')->nullable();

            // Snapshot infos user
            $table->string('customer_firstname');
            $table->string('customer_lastname');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->text('note')->nullable(); // commentaire // addtional info

            // Totaux
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('shipping', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->string('currency')->default('GNF');
            // Adresse livraison (JSON pour MVP)
            $table->json('shipping_address')->nullable();
            // Statut
            $table->tinyInteger('status')->default(0) // 0 = awaiting_payment
                ->comment('0=awaiting_payment, 1=under_review, 2=paid, 3=rejected, 4=cancelled, 5=fulfilled');
            $table->index(['user_id', 'status']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
