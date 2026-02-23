<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->text('about')->nullable();
            $table->boolean('is_verified')->default(false);

            $table->string('subscription_plan', 50)->default('standard'); // standard ou premium
            $table->date('subscription_ends_at')->nullable();             // fin d’essai / abonnement
            $table->boolean('on_trial')->default(false);                  // true pendant les 14 jours d’essai

            $table->string('moneroo_subscription_transaction_id', 191)->nullable();

            $table->tinyInteger('status')->default(1)->index(); // 0=pending, 1=active, 2=blocked
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('accounts');
    }
};
