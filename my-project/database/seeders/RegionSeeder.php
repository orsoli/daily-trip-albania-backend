<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            [
                'name' => 'North',
                'slug' => 'northern-region',
                'description' => 'Covers the mountainous north, known for its rugged landscapes and traditional villages.'
            ],
            [
                'name' => 'Central',
                'slug' => 'central-region',
                'description' => 'The heart of the country with rich history, cultural heritage, and vibrant cities.'
            ],
            [
                'name' => 'South',
                'slug' => 'southern-region',
                'description' => 'Features stunning beaches, Mediterranean climate, and seaside attractions.'
            ],
            [
                'name' => 'East',
                'slug' => 'eastern-region',
                'description' => 'Characterized by historical sites, scenic nature, and authentic rural life.'
            ],
            [
                'name' => 'West',
                'slug' => 'western-region',
                'description' => 'A coastal area with beautiful landscapes, modern cities, and leisure destinations.'
            ]
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}