<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom de l'agence ou du bureau
            $table->string('slug')->unique()->nullable();
            $table->text('details')->nullable(); // Description ou informations supplémentaires
            $table->string('address'); // Adresse physique
            $table->string('phone')->nullable(); // Numéro de téléphone
            $table->string('email')->nullable(); // Adresse e-mail
            $table->string('map_link')->nullable(); // Lien Google Maps (optionnel)
            $table->boolean('status')->default(true); // Statut actif/inactif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
