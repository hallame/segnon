<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->morphs('viewable'); // Article ou Profil Expert
            $table->nullableMorphs('viewer'); // Qui a vu ? (User, Expert, Admin)
            $table->ipAddress('ip')->nullable(); // Adresse IP pour les visiteurs non connectés
            $table->string('slug')->unique()->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('views');
    }
};
