<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            CurrencySeeder::class,
            ServiceSeeder::class,
            RegionSeeder::class,

            AccommodationSeeder::class,
            TourSeeder::class,
            CategoryTourSeeder::class,
            DestinationSeeder::class,
            DestinationTourSeeder::class,
            TourServiceSeeder::class,
            ItinerarySeeder::class,
            BookingSeeder::class,

            GallerySeeder::class,
            BookingDestinationSeeder::class,

        ]);
    }
}