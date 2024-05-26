<?php

namespace App\Modules\Orders\Models;

use App\Modules\Languages\LanguageService;
use App\Modules\Orders\Enums\DeliveryMethod;
use App\Modules\Orders\Enums\OrderStatus;
use App\Modules\Orders\Enums\PaymentMethod;
use App\Modules\Orders\Enums\PaymentStatus;
use App\Modules\Products\ValueObjects\Price;
use App\Modules\Shops\Models\Shop;
use App\Modules\Users\Models\User;
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


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }


    public function getDateAttribute(): string
    {
        return Carbon::parse($this->created_at)->isoFormat('D MMMM YYYY, H:mm');
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
