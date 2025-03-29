<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tour_id'          => $this->faker->numberBetween(1, 10),
            'accommodation_id' => $this->faker->numberBetween(1, 10),
            'guest_name'       => $this->faker->name,
            'guest_email'      => $this->faker->unique()->safeEmail,
            'guest_phone'      => $this->faker->phoneNumber,
            'reservation_date' => $this->faker->dateTimeInInterval('2024-01-01', '+2 year')->format('Y-m-d'),
            'num_people'       => $this->faker->numberBetween(1, 5),
            'total_price'      => $this->faker->numberBetween(50, 500),
            'status'           => $this->faker->randomElement(['confirmed', 'pending', 'canceled']),
            'payment_method'   => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'notes'            => $this->faker->sentence,
        ];
    }
}
