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
        Schema::create('tour_service', function (Blueprint $table) {
            $table->foreignId('tour_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->primary(['tour_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_service');
    }
};