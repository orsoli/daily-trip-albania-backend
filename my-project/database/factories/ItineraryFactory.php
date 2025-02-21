<?php

namespace Database\Factories;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Itinerary>
 */
class ItineraryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Variables
        $tour = Tour::inRandomOrder()->first();
        $names = [];
        $name = $tour->title .' ' . $tour->title . $this->faker->unique()->words(2, true);

        if (!in_array($name, $names)) {
            $names[] = $name;

            return [
                'tour_id'     => Tour::inRandomOrder()->first()->id,
                'name'        => $name,
                'slug'        => Str::slug($name),
                'start_at'    => $this->faker->time('H:i'),
                'lunch_time'  => $this->faker->time('H:i'),
                'end_at'      => $this->faker->time('H:i'),
                'activities'  => $this->faker->paragraph(3),
            ];
        }

    }
}
