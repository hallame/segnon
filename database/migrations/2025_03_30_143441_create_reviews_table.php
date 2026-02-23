<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    public function up(): void{
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->morphs('reviewable');  // Colonne polymorphique (reviewable_type et reviewable_id)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // Client ayant laissé l'avis
            $table->decimal('rating', 2, 1);  // Note entre 1.0 et 5.0
            $table->string('slug')->unique()->nullable();
            $table->text('comment')->nullable();  // Commentaire de l'avis
            $table->foreignId('language_id')->default(1)->constrained('languages')->onDelete('cascade');
            $table->string('identifier')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
