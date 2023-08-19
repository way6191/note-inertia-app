<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = bcrypt('notepass818');

        User::factory()->create([
            'name' => 'way',
            'password' => $password,
        ]);

        User::factory()->create([
            'name' => 'hello',
            'password' => $password,
        ]);
    }
}
