<?php

namespace App\Modules\Products\Factories;

use App\Modules\Languages\LanguageService;
use App\Modules\Products\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariantFactory extends Factory
{
    protected $model = Variant::class;


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
