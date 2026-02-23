<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{

        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Guinea')->unique();
            $table->string('iso_code', 3)->nullable(false)->unique();
            $table->string('slug')->unique()->nullable();
            $table->foreignId('language_id')->default(1)->constrained('languages')->onDelete('cascade');
            $table->string('country_code', 5)->nullable(); // Indicatif téléphonique
            $table->boolean('status')->default(true); // Statut actif/inactif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
