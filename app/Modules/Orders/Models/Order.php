<?php

namespace App\Modules\Orders\Models;

use App\Modules\Common\CommonService;
use App\Modules\Currencies\Models\Currency;
use App\Modules\Languages\LanguageService;
use App\Modules\Languages\Models\Language;
use App\Modules\Orders\Enums\DeliveryMethod;
use App\Modules\Orders\Enums\OrderStatus;
use App\Modules\Orders\Enums\PaymentMethod;
use App\Modules\Orders\Enums\PaymentStatus;
use App\Modules\Orders\Factories\OrderFactory;
use App\Modules\Products\ValueObjects\Price;
use App\Modules\Shops\Models\Shop;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => OrderStatus::class,
        'payment_status' => PaymentStatus::class,
        'payment_method' => PaymentMethod::class,
        'delivery_method' => DeliveryMethod::class,
    ];


    protected static function newFactory(): Factory
    {
        return OrderFactory::new();
    }


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }


    public function scopeWithItems(Builder $query): void
    {
        $query->with([
            'orderItems' => function ($q) {
                $q->join('orders', 'orders.id', 'order_items.order_id')
                    ->select(
                        'order_items.*',
                        'orders.currency_id'
                    )->with([
                        'sku' => function ($q) {
                            $q->join('products', 'products.id', 'skus.product_id')
                                ->join('categories', 'products.category_id', 'categories.id')
                                ->select(
                                    'skus.id',
                                    'skus.name',
                                    'skus.slug',
                                    'products.category_id as category_id',
                                    'categories.slug as category_slug',
                                );
                        }
                    ]);
            }
        ])
        ->with('shop:id,address')
        ->orderByDesc('created_at');
    }


    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::createFromDate($value)->tz(CommonService::$timezone),
        );
    }

    public function getDateAttribute(): string
    {
        return $this->created_at->isoFormat('D MMMM YYYY, H:mm');
    }

    public function getItemsCostFormattedAttribute(): string
    {
        return Price::from($this->items_cost, $this->currency_id, $this->currency_id)->formatted_full;
    }

    public function getTotalCostFormattedAttribute(): string
    {
        return Price::from($this->total_cost, $this->currency_id, $this->currency_id)->formatted_full;
    }

    public function getLocalUrlAttribute(): string
    {
        return url(LanguageService::modifyURL(route('orders', absolute: false), $this->language_id));
    }
}
