<?php

namespace App\Modules\Reviews\Factories;

use App\Modules\Reviews\Models\Reaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReactionFactory extends Factory
{
    protected $model = Reaction::class;


    public function definition(): array
    {
        $date_time = fake()->dateTimeBetween('-3 month');

        return [
//            'review_id' => fake()->randomElement([23, 24]),
            'user_id' => fake()->numberBetween(1, 3),
            'up_down' => fake()->randomElement([true, false]),
            'created_at' => $date_time,
            'updated_at' => $date_time,
        ];
    }
}