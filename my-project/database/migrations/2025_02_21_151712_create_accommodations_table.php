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
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('tour_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();

            $table->string('property_name');
            $table->string('type');
            $table->decimal('price', 10, 2);
            $table->foreignId('default_currency_id')->constrained('currencies')->cascadeOnUpdate()->onDelete('restrict');
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_visible')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
};
