<?php

namespace App\Modules\Shops\Models;

use App\Modules\Common\CommonService;
use App\Modules\Orders\Models\Order;
use App\Modules\Shops\ShopService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\Translatable\HasTranslations;

class Shop extends Model
{
    use HasTranslations;

    public array $translatable = [
        'name',
        'address',
        'info',
    ];

    protected $casts = [
        'location' => 'array',
        'opening_hours' => 'array',
    ];

    protected $guarded = [];


    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }


    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::createFromDate($value)->tz(CommonService::$timezone),
        );
    }


    public function getOpeningHoursHumanAttribute(): Collection
    {
        return new Collection(ShopService::getOpeningHoursForHuman($this->opening_hours));
    }


    public function getLocationStrAttribute(): string
    {
        return implode(', ', $this->location);
    }
}
