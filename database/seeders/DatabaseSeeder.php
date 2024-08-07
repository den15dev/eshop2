<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $this->call([
            UserSeeder::class, // Creates users ONLY if they don't exist yet.
            ReviewSeeder::class, // Add new reviews every run.

//            ReviewAndUserUnseeder::class, // Clear all fake users, reviews, reactions, and update all SKUs' ratings.
        ]);
    }
}
