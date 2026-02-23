<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('location');
            $table->string('city');
            $table->string('district'); // Dist/Village/Quartier
            $table->text('accessibility');
            $table->foreignId('country_id')->constrained('countries')->default(1); // 1 est l'ID de la Guinée dans la table `countries`
            $table->text('history')->nullable();
            $table->string('video')->nullable();
            $table->string('video_url')->nullable();
            $table->string('image')->nullable();
            $table->string('info')->nullable();
            $table->json('meta')->nullable();
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('language_id')->default(1)->constrained('languages')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null'); // Lien vers la table categories
            $table->decimal('price', 30, 2)->nullable();
            $table->tinyInteger('status')->default(1); // Statut (1 = actif, 0 = inactif)
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('map_url')->nullable();
            $table->text('map_description')->nullable();
            $table->timestamps();

            $table->index('country_id');
            $table->index('city');      // si utilisé souvent en filtre
            $table->index('district');  // idem
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('sites');
    }
};
