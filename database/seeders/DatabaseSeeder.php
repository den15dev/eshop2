<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class, // Creates users ONLY if they don't exist yet.
            ReviewSeeder::class, // Add new reviews every run.

//            ReviewAndUserUnseeder::class, // Clear all fake users, reviews, reactions, and update all SKUs' ratings.
        ]);
    }
}
