<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('language_id')->default(1)->constrained('languages')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->boolean('status')->default(1);
            $table->string('slug')->unique()->nullable();
            $table->string('video')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->string('model')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('categories');
    }
};
