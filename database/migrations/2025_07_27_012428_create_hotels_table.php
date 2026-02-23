<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();

            $table->string('slug')->unique()->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->integer('free_rooms')->nullable();
            $table->integer('total_rooms')->nullable();
            $table->string('video')->nullable();
            $table->string('info')->nullable();
            $table->string('type')->nullable();
            $table->string('video_url')->nullable();
            $table->string('address')->nullable();
            $table->string('city');
             $table->string('district')->nullable();
            $table->foreignId('country_id')->constrained('countries')->default(1);
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('language_id')->default(1)->constrained('languages')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->boolean('status')->default(0);

            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();


            $table->index('city');        // filtre par ville
            $table->index('district');    // si tu filtres aussi par district
            $table->index('country_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('hotels');
    }
};
