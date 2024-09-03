<?php

namespace App\Modules\Categories\Factories;

use App\Modules\Categories\Models\Specification;
use App\Modules\Languages\LanguageService;
use Illuminate\Database\Eloquent\Factories\Factory;


class SpecificationFactory extends Factory
{
    protected $model = Specification::class;


    public function definition(): array
    {
        $languages = LanguageService::getAll();

        $name = [];
        $units = [];
        foreach ($languages as $lang) {
            $name[$lang->id] = fake()->words(fake()->numberBetween(3, 7), true);
            $units[$lang->id] = fake()->lexify('???');
        }

        $date_time = fake()->dateTimeBetween('-3 month');

        $specification = [
            'name' => $name,
            'units' => $units,
            'sort' => 1,
            'is_filter' => !fake()->numberBetween(0, 3),
            'is_main' => !fake()->numberBetween(0, 3),
            'created_at' => $date_time,
            'updated_at' => $date_time,
        ];

        if (fake()->numberBetween(0, 3)) unset($specification['units']);

        return $specification;
    }
}
