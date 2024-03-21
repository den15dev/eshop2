<?php

namespace App\Modules\Products\Models;

use App\Modules\Cart\Models\CartItem;
use App\Modules\Categories\CategoryService;
use App\Modules\Categories\Models\Specification;
use App\Modules\Currencies\Models\Currency;
use App\Modules\Favorites\Models\Favorite;
use App\Modules\Orders\Models\OrderItem;
use App\Modules\Products\ValueObjects\Price;
use App\Modules\Promos\Models\Promo;
use App\Modules\Promos\PromoService;
use App\Modules\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\JoinClause;
use Spatie\Translatable\HasTranslations;

class Sku extends Model
{
    use HasTranslations;

    public array $translatable = [
        'name',
        'short_descr',
        'description',
        'promo_name',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    protected $guarded = [];

    const IMG_DIR = 'storage/images/products';


    public function specifications(): BelongsToMany
    {
        return $this->belongsToMany(Specification::class)->withPivot('id', 'spec_value')->using(SpecValue::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(Variant::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


    public function scopeActive(Builder $query): void
    {
        $query->whereDate('skus.available_from', '<=', now())
            ->where(function (Builder $builder) {
                $builder->whereDate('skus.available_until', '>', now())
                    ->orWhereNull('skus.available_until');
            });
    }

    public function getCategorySlugAttribute()
    {
        return $this->category_id
            ? CategoryService::getAll()->firstWhere('id', $this->category_id)->slug
            : null;
    }

    public function getUrlSlugAttribute(): string
    {
        return $this->slug . '-' . $this->id;
    }

    public function getUrlAttribute(): string
    {
        $category_slug = $this->category_id
            ? CategoryService::getAll()->firstWhere('id', $this->category_id)->slug
            : null;

        return route('product', [$category_slug, $this->url_slug]);
    }

    public function getImageSmAttribute(): string
    {
        return get_image(self::IMG_DIR . '/' . $this->id . '/01_80.jpg', 80);
    }

    public function getImageMdAttribute(): string
    {
        return get_image(self::IMG_DIR . '/' . $this->id . '/01_230.jpg', 230);
    }

    public function getPriceFormattedAttribute(): string
    {
        return Price::from($this->price, $this->currency_id)->formatted_full;
    }

    public function getFinalPriceFormattedAttribute(): string
    {
        return Price::from($this->final_price, $this->currency_id)->formatted_full;
    }

    public function getPromoUrlSlugAttribute(): ?string
    {
        return $this->promo_id ? $this->promo_slug . '-' . $this->promo_id : null;
    }
}
