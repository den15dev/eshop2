<?php

namespace App\Modules\Products\Models;

use App\Modules\Products\Factories\AttributeFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Attribute extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $guarded = [];


    protected static function newFactory(): Factory
    {
        return AttributeFactory::new();
    }


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class)->orderBy('name->' . app()->getLocale());
    }
}
