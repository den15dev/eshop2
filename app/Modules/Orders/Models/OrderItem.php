<?php

namespace App\Modules\Orders\Models;

use App\Modules\Orders\Factories\OrderItemFactory;
use App\Modules\Products\Models\Sku;
use App\Modules\Products\ValueObjects\Price;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $guarded = [];

    public $timestamps = false;


    protected static function newFactory(): Factory
    {
        return OrderItemFactory::new();
    }


    public function sku(): BelongsTo
    {
        return $this->belongsTo(Sku::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }


    public function getPriceFormattedAttribute(): string
    {
        return Price::from($this->price, $this->currency_id, $this->currency_id)->formatted_full;
    }

    public function getCostAttribute(): string
    {
        return bcmul($this->price, $this->quantity);
    }

    public function getCostFormattedAttribute(): string
    {
        return Price::from($this->cost, $this->currency_id, $this->currency_id)->formatted_full;
    }
}
