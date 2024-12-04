<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chapter>
 */
class ChapterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wrong = ['á', 'í', 'ó', 'é', 'ã', 'õ', 'â', 'ô', 'à', ' '];
        $correct = ['a', 'i', 'o', 'e', 'a', 'o', 'a', 'o', 'a', '_'];
        $name = fake()->name();
        $tenant = str_replace($wrong, $correct, strtolower($name));

        return [
            'name' => $name,
            'tenant' => $tenant,
        ];
    }
}
