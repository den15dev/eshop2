<?php

namespace App\Modules\Products\Factories;

use App\Modules\Languages\LanguageService;
use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductFactory extends Factory
{
    protected $model = Product::class;


    public function definition(): array
    {
        $languages = LanguageService::getAll();

        $name = [];
        foreach ($languages as $lang) {
            $name[$lang->id] = fake()->words(fake()->numberBetween(2, 4), true);
        }

        return [
            'name' => $name,
        ];
    }
}
