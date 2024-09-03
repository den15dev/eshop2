<?php

namespace App\Modules\Products\Factories;

use App\Modules\Languages\LanguageService;
use App\Modules\Products\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    protected $model = Attribute::class;


    public function definition(): array
    {
        $languages = LanguageService::getAll();

        $name = [];
        foreach ($languages as $lang) {
            $name[$lang->id] = fake()->words(fake()->numberBetween(1, 2), true);
        }

        return [
            'name' => $name,
        ];
    }
}
