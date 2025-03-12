<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $city = $this->faker->city;

        return [
            'region_id'             => $this->faker->numberBetween(1,5),
            'name'                  => $city,
            'slug'                  => Str::slug($city),
            'thumbnail'             => $this->faker->imageUrl(100, 100, 'destinations'),
            'price'                 => $this->faker->randomFloat(2, 10, 1000),
            'default_currency_id'   => 1,
            'country'               => 'Albania',
            'city'                  => $this->faker->city,
            'description'           => $this->faker->paragraph,
            'nearest_airport'       => 'TIA (Tirana International Airport)',
            'latitude'              => $this->faker->latitude,
            'longitude'             => $this->faker->longitude,
        ];
    }
}
