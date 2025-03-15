<?php

namespace Database\Factories;

use App\Models\Accommodation;
use App\Models\Currency;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(2);

        return [
            'guide_id'              => User::where('role_id', 4)->inRandomOrder()->first()->id,
            'default_currency_id'   => Currency::where('is_default', true)->inRandomOrder()->first()->id,
            'region_id'             => Region::inRandomOrder()->first()->id,
            'accommodation_id'      => Accommodation::inRandomOrder()->first()->id,
            'title'                 => $title,
            'slug'                  => Str::slug($title),
            'thumbnail'             => $this->faker->imageUrl(640, 480, 'travel'),
            'description'           => $this->faker->paragraph(3),
            'is_active'             => $this->faker->boolean(80), // 80% chance to be active
            'price'                 => $this->faker->randomFloat(2, 50, 1000),
            'duration'              => $this->faker->randomElement(['Half-day', 'Full-day', '5 hours', '6 houers']),
            'difficulty'            => $this->faker->randomElement(['Easy', 'Moderate', 'Hard']),
            'popularity'            => $this->faker->numberBetween(1, 100),
            'is_featured'           => $this->faker->boolean(20), // 20% chance to be featured
            'rating'                => $this->faker->randomFloat(1, 1, 5),
            'view_count'            => $this->faker->numberBetween(0, 10000),
            'wheelchair_accessible' => $this->faker->boolean(),
            'created_by'            => User::inRandomOrder()->first()->id ?? User::factory(),
            'updated_by'            => User::inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
}
