<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Destination;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookingIds = Booking::pluck('id')->toArray();
        $destinationIds = Destination::pluck('id')->toArray();

        $pairs = [];

        while (count($pairs) < 10) {
            $bookingId = $bookingIds[array_rand($bookingIds)];
            $destinationId = $destinationIds[array_rand($destinationIds)];

            $pair = "{$bookingId}_{$destinationId}";

            // Check if the combination is new
            if (!in_array($pair, $pairs)) {
                $pairs[] = $pair;

                // Inserting into the pivot table
                DB::table('booking_destination')->insert([
                    'booking_id' => $bookingId,
                    'destination_id'    => $destinationId,
                ]);
            }
        }
    }
}
