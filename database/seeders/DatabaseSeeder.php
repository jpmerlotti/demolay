<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Demolay;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vault;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'chapter_id' => 1,
            'demolay_id' => 1,
            'email' => 'test@example.com',
            'password' => Hash::make('12345678'),
        ]);

        Demolay::factory()->create([
            'name' => 'Teste da Silva Pinto',
            'phone' => '(11) 11111-1111',
            'sisdm' => '11111',
            'is_active' => false,
            'user_id' => 1,
            'chapter_id' => 1,
        ]);

        Chapter::factory()->create([
            'vault_id' => 1,
            'name' => fake()->name(),
            'tenant' => 'capitulo_jales',
        ]);

        Vault::factory()->create([
            'chapter_id' => 1,
        ]);

        Transaction::factory(5)->create();
    }
}
