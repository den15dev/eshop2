<?php

namespace App\Modules\Orders\Factories;

use App\Modules\Currencies\Models\Currency;
use App\Modules\Languages\Models\Language;
use App\Modules\Orders\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;


class OrderFactory extends Factory
{
    protected $model = Order::class;


    public function definition(): array
    {
        $cost = fake()->randomFloat(2, 1000, 20000);

        return [
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'language_id' => Language::inRandomOrder()->first()->id,
            'currency_id' => Currency::inRandomOrder()->first()->id,
            'items_cost' => $cost,
            'total_cost' => $cost,
        ];
    }
}
