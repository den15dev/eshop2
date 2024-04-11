<?php

namespace App\Modules\Products\Models;

use App\Modules\Cart\CartService;
use App\Modules\Cart\Models\CartItem;
use App\Modules\Catalog\ComparisonService;
use App\Modules\Categories\CategoryService;
use App\Modules\Categories\Models\Specification;
use App\Modules\Currencies\CurrencyService;
use App\Modules\Currencies\Models\Currency;
use App\Modules\Favorites\FavoriteService;
use App\Modules\Favorites\Models\Favorite;
use App\Modules\Orders\Models\OrderItem;
use App\Modules\Products\ValueObjects\Price;
use App\Modules\Promos\Models\Promo;
use App\Modules\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
        'available_from' => 'date',
        'available_until' => 'date',
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


    public static function booted(): void
    {
        static::saved(function (self $model) {
            Cache::forget('categories');
        });

        static::updated(function (self $model) {
            Cache::forget('categories');
        });

        static::deleted(function (self $model) {
            Cache::forget('categories');
        });
    }


    public function scopeGetCards(Builder $query): void
    {
        $query->join('products', 'skus.product_id', 'products.id')
            ->joinPromos()
            ->selectForCards()
            ->active();
    }

    public function scopeActive(Builder $query): void
    {
        $query->whereDate('skus.available_from', '<=', now())
            ->where(function (Builder $builder) {
                $builder->whereDate('skus.available_until', '>', now())
                    ->orWhereNull('skus.available_until');
            });
    }

    public function scopeJoinPromos(Builder $query): void
    {
        $query->leftJoin('promos', function (JoinClause $join) {
            $current_date = date('Y-m-d H:i:s');
            $join->on('skus.promo_id', '=', 'promos.id')
                ->whereDate('promos.starts_at', '<=', $current_date)
                ->whereDate('promos.ends_at', '>=', $current_date);
        });
    }

    public function scopeSelectForCards(Builder $query): void
    {
        $query->select(
            'skus.id',
            'skus.name',
            'skus.slug',
            'products.category_id',
            'skus.short_descr',
            'skus.currency_id',
            'skus.price',
            'skus.discount_prc',
            'skus.final_price',
            'skus.rating',
            'skus.vote_num',
            'promos.id as promo_id',
            'promos.name as promo_name',
            'promos.slug as promo_slug',
        );
    }

    public function scopeFilterByBrands(Builder $query, array $query_arr): void
    {
        if (isset($query_arr['brands'])) {
            $query = $query->whereIn('products.brand_id', $query_arr['brands']);
        }
    }

    public function scopeFilterByPrice(Builder $query, array $query_arr): void
    {
        if (isset($query_arr['price_min']) && is_numeric($query_arr['price_min'])) {
            $price_min = bcmul(Price::parse($query_arr['price_min']), CurrencyService::$cur_currency->exchange_rate);
            $query = $query->where(DB::raw('skus.final_price * ' . CurrencyService::RATE_SUBQUERY), '>=', $price_min);
        }

        if (isset($query_arr['price_max']) && is_numeric($query_arr['price_max'])) {
            $price_max = bcmul(Price::parse($query_arr['price_max']), CurrencyService::$cur_currency->exchange_rate);
            $query = $query->where(DB::raw('skus.final_price * ' . CurrencyService::RATE_SUBQUERY), '<=', $price_max);
        }
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

    public function getRatingFormattedAttribute(): ?string
    {
        $decimal_sep = CurrencyService::$cur_currency->decimal_sep;
        $thousands_sep = CurrencyService::$cur_currency->thousands_sep;

        return $this->rating ? number_format($this->rating, 1, $decimal_sep, $thousands_sep) : null;
    }

    public function getIsActiveAttribute(): bool
    {
        return (!$this->available_from || $this->available_from->isPast())
            && (!$this->available_until || $this->available_until->isFuture());
    }

    public function getInCartAttribute(): int
    {
        $cart = CartService::getCart();
        if (!count($cart)) return 0;

        $in_cart = 0;
        foreach ($cart as $cart_item) {
            if ($this->id === $cart_item[0]) {
                $in_cart = $cart_item[1];
                break;
            }
        }

        return $in_cart;
    }

    public function getIsFavoriteAttribute(): bool
    {
        $favs = FavoriteService::getFavorites();

        return in_array($this->id, $favs);
    }

    public function getIsComparingAttribute(): bool
    {
        $comparison_arr = ComparisonService::get()?->sku_ids;

        return $comparison_arr && in_array($this->id, $comparison_arr);
    }
}
