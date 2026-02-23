<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('circuits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('location')->nullable();
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();

            $table->string('image')->nullable();
            $table->string('note')->nullable();
            $table->string('video')->nullable();
            $table->string('video_url')->nullable();
            $table->tinyInteger('status')->default(1); // Statut (1 = actif, 0 = inactif)
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null'); // Lien vers la table categories

            $table->foreignId('language_id')->default(1)->constrained('languages')->onDelete('cascade');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('map_url')->nullable();
            $table->text('map_description')->nullable();

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('circuits');
    }
};
