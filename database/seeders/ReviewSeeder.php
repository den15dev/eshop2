<?php

namespace Database\Seeders;

use App\Modules\Reviews\Models\Reaction;
use App\Modules\Reviews\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 25; $i++) {
            Review::newFactory()
                ->hasReactions(rand(2, 15))
                ->create();
        }
    }
}
