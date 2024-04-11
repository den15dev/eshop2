<?php

namespace App\Modules\Brands\Models;

use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
    use HasTranslations;

    public array $translatable = ['description'];
    protected $guarded = [];
    const IMG_DIR = 'storage/images/brands';


    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    public function getUrlAttribute(): ?string
    {
        return $this->slug ? route('brand', $this->slug) : null;
    }

    public function getImageUrlAttribute(): string
    {
        return getImageBySlug(self::IMG_DIR . '/' . $this->slug);
    }
}
