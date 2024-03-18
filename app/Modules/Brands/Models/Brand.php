<?php

namespace App\Modules\Brands\Models;

use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
//    use HasFactory;

    use HasTranslations;

    public array $translatable = ['description'];

    protected $guarded = [];


    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
