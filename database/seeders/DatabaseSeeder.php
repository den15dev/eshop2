<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Creates 20 users with emails ending "...@tmail.tst" ONLY if they don't exist yet.
            UserSeeder::class,

            // Add 100 new reviews from that users with up to 5 reactions on each review.
            ReviewSeeder::class,

            // Clear all fake users, reviews, reactions, and update all SKUs' ratings.
            // ReviewAndUserUnseeder::class,
        ]);
    }
}
