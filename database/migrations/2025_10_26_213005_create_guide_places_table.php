<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {

        // pivot polymorphe Guide ↔ Site/Museum/Monument
        Schema::create('guide_places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guide_id')->constrained('guides')->cascadeOnDelete();
            $table->morphs('placeable'); // placeable_type, placeable_id (Site, Museum, Monument)

            $table->decimal('price', 32, 2)->default(0);
            $table->enum('pricing_type', ['per_outing','per_person','per_group','per_hour'])->default('per_outing')->index();
            $table->unsignedInteger('min_people')->nullable();
            $table->unsignedInteger('max_people')->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('approved')->default(true);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('guide_places');
    }
};
