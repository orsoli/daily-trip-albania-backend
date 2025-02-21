<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingTourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookingIds = Booking::pluck('id')->toArray();
        $tourIds = Tour::pluck('id')->toArray();

        $pairs = []; // Për të ruajtur kombinimet unike

        while (count($pairs) < 10) { // Ndrysho numrin sipas nevojës
            $bookingId = $bookingIds[array_rand($bookingIds)];
            $tourId = $tourIds[array_rand($tourIds)];

            $pair = "{$bookingId}_{$tourId}";

            // Kontrollo nëse kombinimi është i ri
            if (!in_array($pair, $pairs)) {
                $pairs[] = $pair;

                // Inserting into the pivot table
                DB::table('booking_tour')->insert([
                    'booking_id' => $bookingId,
                    'tour_id'    => $tourId,
                ]);
            }
        }
    }
}
