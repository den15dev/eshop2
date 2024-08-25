<?php

namespace App\Modules\Categories\Factories;

use App\Modules\Categories\Models\Specification;
use App\Modules\Languages\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;


class SpecificationFactory extends Factory
{
    protected $model = Specification::class;

    private static int $spec_num;


    public function __construct()
    {
        parent::__construct();

        self::$spec_num = Specification::count();
    }


    public function definition(): array
    {
        $lang_num = Language::count();

        $name = [];
        $units = [];
        for ($i = 0; $i < $lang_num; $i++) {
            $name[] = fake()->words(fake()->numberBetween(3, 7), true);
            $units[] = fake()->lexify('???');
        }
        $date_time = fake()->dateTimeBetween('-3 month');

        return [
            'category_id' => 3, // "cpu" category
            'name' => $name,
            'units' => $units,
            'sort' => self::$spec_num++,
            'is_filter' => (bool) fake()->numberBetween(0, 7),
            'is_main' => (bool) fake()->numberBetween(0, 7),
            'created_at' => $date_time,
            'updated_at' => $date_time,
        ];
    }
}
