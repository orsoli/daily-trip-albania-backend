<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $propertyName = $this->faker->company . ' ' . $this->faker->word;

        return [
            'destination_id'      => Destination::inRandomOrder()->first()->id ?? null,
            'tour_id'             => Tour::inRandomOrder()->first()->id ?? null,
            'property_name'       => $propertyName,
            'slug'                => Str::slug($propertyName),
            'thumbnail'           => $this->faker->imageUrl(100, 100, 'accommodations'),
            'type'                => $this->faker->randomElement(['Hotel', 'BNB', 'Apartment']),
            'price'               => $this->faker->randomFloat(2, 10, 1000),
            'default_currency_id' => 1,
            'description'         => $this->faker->paragraph,
            'latitude'            => $this->faker->latitude,
            'longitude'           => $this->faker->longitude,
        ];
    }
}
