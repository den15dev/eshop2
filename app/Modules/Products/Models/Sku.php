<?php

namespace App\Modules\Products\Models;

use App\Modules\Cart\CartService;
use App\Modules\Cart\Models\CartItem;
use App\Modules\Catalog\ComparisonService;
use App\Modules\Categories\Models\Specification;
use App\Modules\Common\CommonService;
use App\Modules\Currencies\CurrencyService;
use App\Modules\Currencies\Models\Currency;
use App\Modules\Favorites\FavoriteService;
use App\Modules\Favorites\Models\Favorite;
use App\Modules\Orders\Models\OrderItem;
use App\Modules\Products\Factories\SkuFactory;
use App\Modules\Products\ValueObjects\Price;
use App\Modules\Promos\Models\Promo;
use App\Modules\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Sku extends Model
{
    use HasTranslations;

    public array $translatable = [
        'name',
        'short_descr',
        'description',
        'promo_name',
        'product_name',
        'category_name',
    ];

    protected $casts = [
        'images' => 'array',
        'available_from' => 'datetime',
        'available_until' => 'datetime',
    ];

    protected $guarded = [];

    const IMG_DIR = 'products';
    const IMG_SIZES = [
        'tn' => 80,
        'sm' => 230,
        'md' => 600,
        'lg' => 1400,
    ];
    const DISCOUNT = 'COALESCE(skus.discount, promos.discount, 0)';
    const DISCOUNT_FILTERED = 'COALESCE(skus.discount, (CASE WHEN promos.starts_at <= NOW() AND promos.ends_at > NOW() THEN promos.discount ELSE NULL END), 0)';
    const FINAL_PRICE = '((skus.price * (100 - COALESCE(skus.discount, promos.discount, 0)) / 100))';


    protected static function newFactory(): Factory
    {
        return SkuFactory::new();
    }


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
            ->join('categories', 'products.category_id', 'categories.id')
            ->joinActivePromos()
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

    public function scopeJoinActivePromos(Builder $query): void
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
            'skus.code',
            'products.category_id',
            'categories.slug as category_slug',
            'skus.short_descr',
            'skus.currency_id',
            'skus.price',
            DB::raw(self::DISCOUNT . ' as discount'),
            'skus.rating',
            'skus.vote_num',
            'promos.id as promo_id',
            'promos.name as promo_name',
            'promos.slug as promo_slug',
            'promos.discount as promo_discount',
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
            $price_min = bcmul(Price::parse($query_arr['price_min']), CurrencyService::getCurrent()->exchange_rate);
            $query = $query->where(DB::raw(self::FINAL_PRICE . ' * ' . CurrencyService::RATE_SUBQUERY), '>=', $price_min);
        }

        if (isset($query_arr['price_max']) && is_numeric($query_arr['price_max'])) {
            $price_max = bcmul(Price::parse($query_arr['price_max']), CurrencyService::getCurrent()->exchange_rate);
            $query = $query->where(DB::raw(self::FINAL_PRICE . ' * ' . CurrencyService::RATE_SUBQUERY), '<=', $price_max);
        }
    }


    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::createFromDate($value)->tz(CommonService::$timezone),
        );
    }

    public function getUrlSlugAttribute(): string
    {
        return $this->slug . '-' . $this->id;
    }

    public function getUrlAttribute(): string
    {
        return route('product', [$this->category_slug, $this->url_slug]);
    }

    public function getReviewsUrlAttribute(): string
    {
        return route('reviews', [$this->category_slug, $this->url_slug]);
    }

    public function getFinalPriceAttribute(): string
    {
        $multiplier = (100 - $this->discount) / 100;

        return bcmul($this->price, $multiplier);
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
        $decimal_sep = CurrencyService::getCurrent()->decimal_sep;
        $thousands_sep = CurrencyService::getCurrent()->thousands_sep;

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


    public function getImageURL(string $size, int|string $num = 1): ?string
    {
        if (!is_numeric($num)) return null;

        return Storage::disk('s3tw')->url('eshop/products/' . $this->code . '/' . sprintf('%02d', $num) . '_' . $size . '.jpg');
    }
}
