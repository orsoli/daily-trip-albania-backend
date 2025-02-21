<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Tour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the id's of services and tours
        $tourIds = Tour::pluck('id')->toArray();
        $servicesIds = Service::pluck('id')->toArray();

        $pairs = [];

        for ($i=0; $i < 10; $i++) {
            $tourId = $tourIds[array_rand($tourIds)];
            $serviceId = $servicesIds[array_rand($servicesIds)];
            $pair = "{$tourId}_{$serviceId}";


            if (!in_array($pair, $pairs)) {

                $pairs[] = $pair;

                 DB::table('tour_service')->insert([
                     'tour_id'    => $tourId,
                     'service_id' => $serviceId,
                 ]);
            }
        }
    }
}