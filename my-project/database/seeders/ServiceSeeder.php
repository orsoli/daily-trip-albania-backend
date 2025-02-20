<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::insert([
            [
                'name'        => 'Accommodation',
                'slug'        => 'accommodation',
                'description' => 'Hotel or house for stay'
            ],
            [
                'name'        => 'Free Tickets',
                'slug'        => 'free-tickets',
                'description' => 'Tickets included in the price'
            ],
            [
                'name'        => 'Meals Included',
                'slug'        => 'meals-included',
                'description' => 'Breakfast, lunch, or dinner included'
            ],
            [
                'name'        => 'Tour Guide',
                'slug'        => 'tour-guide',
                'description' => 'Professional guide during the tour'
            ],
            [
                'name'        => 'Transportation',
                'slug'        => 'transportation',
                'description' => 'Transport included for the destination'
            ],
            [
                'name'        => 'Travel Insurance',
                'slug'        => 'travel-insurance',
                'description' => 'Insurance included for the trip'
            ],
        ]);
    }
}