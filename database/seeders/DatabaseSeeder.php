<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(250)
            ->create();

        $datetime = now();

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'j.doe@example.com',
            'created_at' => $datetime,
            'updated_at' => $datetime,
        ]);
    }
}
