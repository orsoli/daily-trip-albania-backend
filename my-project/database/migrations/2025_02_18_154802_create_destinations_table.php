<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            //** Guide experiences info */
            $table->boolean('is_active')->default(false);
            $table->integer('duration')->nullable();
            $table->string('difficulty')->nullable();
            $table->integer('max_people')->nullable();
            $table->integer('min_people')->nullable();

            //** Location */
            $table->string('country');
            $table->string('city')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            //** Ratings and Popularity */
            $table->integer('popularity')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->integer('rating')->default(0);
            $table->integer('review_count')->default(0);

            $table->string('nearest_airport')->nullable();
            $table->boolean('public_transport_available')->default(false);
            $table->boolean('wheelchair_accessible')->default(false);

            //** Relations with other tables */
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};