<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Demolay>
 */
class DemolayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->numerify('(##) #####-####'),
            'sisdm' => fake()->numerify('####'),
            'is_active' => false,
            'birthdate' => fake()->dateTimeBetween('-12 years', '-12 years')->format('Y-m-d H:i:s'),
            'user_id' => 1,
        ];
    }

}
