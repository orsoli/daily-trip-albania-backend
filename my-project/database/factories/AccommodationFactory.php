<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Accomodation>
 */
class AccommodationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'destination_id' => Destination::inRandomOrder()->first()->id ?? null,
            'tour_id'        => Tour::inRandomOrder()->first()->id ?? null,
            'property_name'  => $this->faker->company . ' ' . $this->faker->word,
            'type'           => $this->faker->randomElement(['Hotel', 'BNB', 'Apartment']),
            'description'    => $this->faker->paragraph,
            'latitude'       => $this->faker->latitude,
            'longitude'      => $this->faker->longitude,
        ];
    }
}
