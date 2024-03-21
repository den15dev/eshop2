<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Translatable\HasTranslations;

class SpecValue extends Pivot
{
    use HasTranslations;

    public array $translatable = [
        'spec_value',
    ];

    protected $guarded = [];
}