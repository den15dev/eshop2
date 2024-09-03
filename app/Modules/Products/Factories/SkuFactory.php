<?php

namespace App\Modules\Products\Factories;

use App\Modules\Languages\LanguageService;
use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkuFactory extends Factory
{
    protected $model = Sku::class;


    public function definition(): array
    {
        $languages = LanguageService::getAll();

        $name = [];
        $short_descr = [];
        $description = [];
        foreach ($languages as $lang) {
            $name[$lang->id] = fake()->words(fake()->numberBetween(3, 5), true);
            $short_descr[$lang->id] = fake()->words(fake()->numberBetween(6, 8), true);
            $description[$lang->id] = fake()->realText(rand(100, 500));
        }

        $sku = [
            'name' => $name,
            'slug' => str()->slug($name['en']),
            'sku' => fake()->regexify('[A-Z]{5}-[0-9]{4}'),
            'short_descr' => $short_descr,
            'description' => $description,
            'price' => fake()->randomFloat(2, 20, 20000),
            'discount' => fake()->numberBetween(0, 50),
            'rating' => fake()->randomFloat(2, 0, 5),
            'vote_num' => fake()->numberBetween(1, 50),
            'images' => ['01', '02'],
            'available_from' => now()->subDay(),
        ];

        if (fake()->numberBetween(0, 4)) unset($sku['discount']);
        if (fake()->numberBetween(0, 1)) {
            unset($sku['rating']);
            unset($sku['vote_num']);
        }

        return $sku;
    }
}
