<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('image')->nullable();
            $table->string('username')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->text('address')->nullable(); // Adresse du partenaire
            $table->text('description')->nullable(); // Description du partenaire (activité, secteur, etc.)
            $table->string('website')->nullable(); // Site web du partenaire
            $table->string('logo')->nullable(); // Logo du partenaire (chemin d'accès ou URL)
            $table->tinyInteger('status')->default(1); // Statut du partenariat (1 = actif, 0 = inactif)
            $table->foreignId('site_id')->nullable()->constrained('sites')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null'); // Lien vers la table categories
            $table->foreignId('language_id')->default(1)->constrained('languages')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
