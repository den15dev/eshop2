<?php

namespace App\Modules\Products\Models;

use App\Modules\Brands\Models\Brand;
use App\Modules\Categories\Models\Category;
use App\Modules\Common\CommonService;
use App\Modules\Products\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Casts\Attribute as ModelAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    public array $translatable = [
        'name',
        'category_name',
    ];

    protected $guarded = [];


    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function skus(): HasMany
    {
        return $this->hasMany(Sku::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class)->orderBy('id');
    }


    protected function createdAt(): ModelAttribute
    {
        return ModelAttribute::make(
            get: fn (string $value) => Carbon::createFromDate($value)->tz(CommonService::$timezone),
        );
    }
}
