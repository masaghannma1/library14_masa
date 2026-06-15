<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
        'user_id' => \App\Models\User::factory(),
        'name' => fake()->name(),
        'gender' => fake()->randomElement(['M','F']),
        'DOB' => fake()->date(),
        'phone' => fake()->unique()->phoneNumber(),
        'avatar' => null,
        'lang' => fake()->randomElement(['en','ar']),
    ];
    }
}
