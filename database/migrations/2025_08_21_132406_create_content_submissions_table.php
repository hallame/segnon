<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('content_submissions', function (Blueprint $table) {
            $table->id();
            $table->morphs('model'); // model_type, model_id
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // auteur

            $table->string('operation')->default('update'); // create|update|delete|publish...
            $table->json('changes')->nullable();            // diff proposé
            $table->json('before')->nullable();             // snapshot avant (optionnel)

            $table->foreignId('status_id')->constrained('moderation_statuses');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->text('comment')->nullable();

            $table->timestamps();
            $table->softDeletes();
            // Index utiles
            $table->index(['account_id','status_id','created_at']);
            $table->index(['model_type','model_id','status_id']);
            $table->index(['user_id','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('content_submissions');
    }
};
