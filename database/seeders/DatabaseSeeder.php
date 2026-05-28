<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin di My House 44
        User::factory()->create([
            'name' => 'Maurizio Lombardo',
            'email' => 'admin@maohouse44.it',
            'password' => bcrypt('MaoHouse44!'),
        ]);
    }
}
