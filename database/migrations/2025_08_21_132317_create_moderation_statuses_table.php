<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('moderation_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();   // "pending","approved", ...
            $table->string('status')->unique();   // "pending","approved", ...
            $table->boolean('is_final')->default(false);   // ex: approved/rejected = true
            $table->unsignedInteger('sort')->default(0);   // ordre d’affichage (optionnel)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('moderation_statuses');
    }
};
