<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable()->unique();
            $table->morphs('bookable'); // bookable_type + bookable_id
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();
            // User
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            // Dates de réservation
            $table->dateTime('check_in');
            $table->dateTime('check_out');

            // Infos participants
            $table->unsignedInteger('guests')->default(1);
            $table->boolean('is_group')->default(false);

            // Tarification
            $table->decimal('unit_price', 20, 2)->nullable();
            $table->decimal('amount', 20, 2)->nullable();
            $table->json('pricing_details')->nullable(); // détail calcul : nuits, options, taxes

            // Statuts réservation
            $table->tinyInteger('status')->default(0)->comment('0=pending, 1=confirmed, 2=cancelled, 3=completed');

            // Statuts paiement
            $table->tinyInteger('payment_status')->default(0)->comment('0=unpaid, 1=awaiting_verif, 2=verified, 3=rejected');
            $table->string('payment_method')->nullable();
            $table->dateTime('payment_due_at')->nullable();

            // Reçu paiement
            $table->string('payment_receipt_path')->nullable();
            $table->string('payment_reference')->nullable();

            // Référence / suivi
            $table->string('confirmation_code')->nullable()->unique();
            $table->string('source')->nullable()->default('web'); // web, mobile, admin
            $table->text('note')->nullable();
            $table->text('cancellation_reason')->nullable();

            $table->foreignId('language_id')->default(1)->constrained('languages')->cascadeOnDelete();

            $table->foreignId('assigned_guide_id')->nullable()->constrained('guides')->nullOnDelete();
            $table->index(['assigned_guide_id']);

            // Index utiles
            $table->index(['check_in', 'check_out']);
            $table->index(['status', 'payment_status']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('bookings');
    }
};
