<?php

namespace App\Modules\Categories\Models;

use App\Modules\Categories\Factories\SpecificationFactory;
use App\Modules\Products\Models\Sku;
use App\Modules\Products\Models\SpecValue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Specification extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'units', 'spec_value'];

    protected $guarded = [];


    protected static function newFactory(): Factory
    {
        return SpecificationFactory::new();
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function skus(): BelongsToMany
    {
        return $this->belongsToMany(Sku::class)->withPivot('id', 'spec_value')->using(SpecValue::class);
    }
}
