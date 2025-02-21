<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Destination>
 */
class DestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'region_id'       => $this->faker->numberBetween(1,5),
            'name'            => $this->faker->city,
            'country'         => 'Albania',
            'city'            => $this->faker->city,
            'description'     => $this->faker->paragraph,
            'nearest_airport' => 'TIA (Tirana International Airport)',
            'latitude'        => $this->faker->latitude,
            'longitude'       => $this->faker->longitude,
        ];
    }
}
