<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('outings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->cascadeOnDelete(); // Platform
            $table->foreignId('guide_id')->nullable()->constrained('guides')->nullOnDelete();
            $table->morphs('outable'); // cible : Site, Museum, Monument
            $table->string('title')->nullable();          // ex: "Visite guidée matin"
            $table->text('description')->nullable();
            $table->timestamp('start_at');
            $table->timestamp('end_at')->nullable();
            $table->unsignedInteger('capacity')->default(20);
            $table->unsignedInteger('booked_count')->default(0);
            $table->decimal('price', 10, 2)->nullable();  // override éventuel

            $table->enum('status', ['draft','pending','published','cancelled'])->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->index(['outable_type','outable_id','start_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outings');
    }
};
