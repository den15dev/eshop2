<?php

namespace App\Modules\Brands\Factories;

use App\Modules\Brands\Models\Brand;
use App\Modules\Languages\LanguageService;
use Illuminate\Database\Eloquent\Factories\Factory;


class BrandFactory extends Factory
{
    protected $model = Brand::class;


    public function definition(): array
    {
        $languages = LanguageService::getAll();

        do {
            $name = $this->faker->company();
        } while (
            Brand::on(config('database.testing'))
            ->where('name', $name)
            ->exists()
        );

        $description = [];
        foreach ($languages as $lang) {
            $description[$lang->id] = fake()->realText(rand(100, 500));
        }

        return [
            'name' => $name,
            'slug' => str()->slug($name),
            'description' => $description,
        ];
    }
}
