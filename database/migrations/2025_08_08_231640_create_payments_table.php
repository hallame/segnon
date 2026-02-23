<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->morphs('payable'); // payable_id + payable_type
            $table->string('reference')->nullable()->unique();
            $table->foreignId('payment_method_id')->constrained('payment_methods')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->tinyInteger('status')->default(0)->index(); // 0=submitted,1=verified,2=rejected

            $table->decimal('amount', 30, 2)->default(0);
            $table->string('currency')->default('GNF');
            $table->string('transaction_number')->nullable();
            $table->json('details')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable();
            $table->text('note')->nullable(); // commentaire admin
            $table->timestamps();

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
