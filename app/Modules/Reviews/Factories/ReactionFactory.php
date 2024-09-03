<?php

namespace App\Modules\Reviews\Factories;

use App\Modules\Reviews\Models\Reaction;
use Illuminate\Database\Eloquent\Factories\Factory;


class ReactionFactory extends Factory
{
    protected $model = Reaction::class;


    public function definition(): array
    {
        return [
            'up_down' => (bool) rand(0, 1),
        ];
    }
}
