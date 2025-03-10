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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tour_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('accommodation_id')->nullable()->constrained()->nullOnDelete();

            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone');
            $table->date('reservation_date');
            $table->integer('num_people')->unsigned();
            $table->decimal('total_price', 10, 2);
            $table->string('status');
            $table->string('payment_method');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};