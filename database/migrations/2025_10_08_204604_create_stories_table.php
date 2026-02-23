<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique();

            // IMPORTANT: accounts.id doit être unsigned BIGINT (bigIncrements / id())
            $table->foreignId('account_id')->nullable()->constrained('accounts')->nullOnDelete();

            $table->morphs('storyable'); // storyable_type, storyable_id

            // Métadonnées
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('language', 10)->default('fr'); // <-- manquait
            $table->text('summary')->nullable();

            // Fichiers
            $table->string('audio')->nullable();
            $table->string('video')->nullable();
            $table->unsignedInteger('audio_duration')->nullable();
            $table->unsignedBigInteger('audio_size')->nullable();
            $table->unsignedSmallInteger('audio_bitrate_kbps')->nullable();
            $table->unsignedInteger('audio_samplerate_hz')->nullable();
            $table->unsignedTinyInteger('audio_channels')->nullable();
            $table->longText('transcript')->nullable();

            // Workflow
            $table->enum('status', ['draft','pending','approved','rejected'])->default('draft');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();

            // Tri local
            $table->unsignedInteger('position')->default(0);

            // Traçabilité
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();
            // Index
            $table->unique(['account_id','slug']);
            $table->index(['account_id','status','is_published']);
            $table->index('language');

            // Full-text (MySQL 8+)
            $table->fullText(['name','summary','transcript']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('stories');
    }
};
