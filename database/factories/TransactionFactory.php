<?php

namespace Database\Factories;

use App\Enums\TransactionTypesEnum;
use App\Models\Vault;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(TransactionTypesEnum::cases()),
            'amount_cents' => fake()->randomNumber(7),
            'description' => fake()->text(100),
            'vault_id' => Vault::all()->first(),
        ];
    }
}
