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
        // Admin di Mau House 44
        User::factory()->create([
            'name' => 'Maurizio Lombardo',
            'email' => 'admin@maohouse44.it',
            'password' => bcrypt('MaoHouse44!'),
        ]);
    }
}
