<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('account_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->cascadeOnDelete();
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();

            // État & cycle de vie
            $table->boolean('is_enabled')->default(true); // simple et efficace
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('deactivated_at')->nullable();

            // Paramètres spécifiques au couple (ex: devise, options d’affichage…)
            $table->json('settings')->nullable(); // {"currency":"XOF","booking_flow":"manual"}

            // (Optionnel) gestion commerciale si un jour tu factures par module
            $table->timestamp('trial_ends_at')->nullable();
            $table->string('billing_plan')->nullable(); // ou FK vers une table plans si besoin

            $table->timestamps();

            // Unicité : un même module ne peut exister qu’une fois par compte
            $table->unique(['account_id','module_id']);

            // Accès fréquents
            $table->index(['account_id','is_enabled']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('account_modules');
    }
};
