<?php

namespace App\Modules\Orders\Factories;

use App\Modules\Orders\Models\OrderItem;
use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;


class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;


    public function definition(): array
    {
        return [
            'sku_id' => Sku::inRandomOrder()->first()->id,
            'quantity' => fake()->numberBetween(1, 5),
            'price' => fake()->randomFloat(2, 500, 2000),
        ];
    }
}
