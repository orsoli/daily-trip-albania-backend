<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DestinationTourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the id's of destinations and tours
        $destinationIds = Destination::pluck('id')->toArray();
        $tourIds = Tour::pluck('id')->toArray();

        $pairs = [];

        for ($i=0; $i < 10; $i++) {
            $destinationId = $destinationIds[array_rand($destinationIds)];
            $tourId = $tourIds[array_rand($tourIds)];
            $pair = "{$destinationId}_{$tourId}";


            if (!in_array($pair, $pairs)) {

                $pairs[] = $pair;

                 DB::table('destination_tour')->insert([
                    'destination_id' => $destinationId,
                    'tour_id'        => $tourId,
                 ]);
            }
        }
    }
}