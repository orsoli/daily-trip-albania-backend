<?php

namespace Database\Factories;

use App\Models\Accommodation;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'destination_id'    => Destination::inRandomOrder()->first()->id,
            'tour_id'           => Tour::inRandomOrder()->first()->id,
            'accommodation_id'  => Accommodation::inRandomOrder()->first()->id,
            'url'               => $this->faker->imageUrl(),
            'caption'           => $this->faker->sentence(),
            'order'             => $this->faker->numberBetween(1, 100),
        ];
    }
}
