<?php

namespace App\Modules\Products\Models;

use App\Modules\Products\Factories\VariantFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Variant extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $guarded = [];


    protected static function newFactory(): Factory
    {
        return VariantFactory::new();
    }


    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function skus(): BelongsToMany
    {
        return $this->belongsToMany(Sku::class);
    }
}
