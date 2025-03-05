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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guide_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('default_currency_id')->constrained('currencies')->cascadeOnUpdate()->onDelete('restrict');
            $table->foreignId('region_id')->constrained('regions')->cascadeOnUpdate()->onDelete('restrict');

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->decimal('price', 10, 2);
            $table->string('duration')->nullable();
            $table->string('difficulty')->nullable();
            $table->unsignedInteger('popularity')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->decimal('rating', 3, 2)->default(0);
            $table->unsignedInteger('view_count')->default(0);
            $table->boolean('wheelchair_accessible')->default(false);

            $table->timestamps();
            $table->string('created_by')->default('from system');
            $table->string('updated_by')->default('not deleted');
            $table->softDeletes();
            $table->string('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};