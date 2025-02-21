<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //     'role_id' => $role->id,
        //     'first_name' => config('app.super_admin_first_name'),
        //     'last_name' => config('app.super_admin_last_name'),
        //     'email' => config('app.super_admin_email'),
        //     'date_of_birth' => config('app.super_admin_date_of_birth'),
        //     'personal_nr' => config('app.super_admin_personal_nr'),
        //     'password' => Hash::make(config('app.super_admin_password')),

        return [
            'role_id' => $this->faker->numberBetween(1,4),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'date_of_birth' => $this->faker->date(),
            'personal_nr' => $this->faker->numberBetween(1000000000, 9999999999),
            'email_verified_at' => now(),
            'password' => Hash::make('1234'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    // public function unverified(): static
    // {
    //     return $this->state(fn (array $attributes) => [
    //         'email_verified_at' => null,
    //     ]);
    // }
}
