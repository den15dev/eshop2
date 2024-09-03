<?php

namespace App\Modules\Reviews\Factories;

use App\Modules\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;


class ReviewFactory extends Factory
{
    protected $model = Review::class;


    public function definition(): array
    {
//        $date_time = fake()->dateTimeBetween('-3 month');

        return [
            'term' => $this->faker->randomElement(['days', 'weeks', 'months', 'years']),
            'mark' => $this->faker->numberBetween(1, 5),
            'pros' => $this->faker->realText(rand(100, 400)),
            'cons' => $this->faker->realText(rand(100, 400)),
            'comnt' => $this->faker->realText(rand(100, 400)),
//            'created_at' => $date_time,
//            'updated_at' => $date_time,
        ];
    }
}
