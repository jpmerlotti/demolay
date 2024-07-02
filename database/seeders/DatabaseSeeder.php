<?php

namespace Database\Seeders;

use App\Models\Demolay;
use App\Models\User;
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
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('12345678')
        ]);

        Demolay::factory()->create([
            'name' => 'Teste da Silva Pinto',
            'phone' => '(11) 11111-1111',
            'sisdm' => '11111',
            'is_active' => false,
            'user_id' => 1
        ]);
    }
}
