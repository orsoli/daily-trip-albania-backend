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
        Schema::create('destination_tour', function (Blueprint $table) {
            $table->foreignId('destination_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('tour_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->primary(['destination_id', 'tour_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_tour');
    }
};
