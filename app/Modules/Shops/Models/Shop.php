<?php

namespace App\Modules\Shops\Models;

use App\Modules\Shops\ShopService;
use Illuminate\Database\Eloquent\Model;
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


    public function getOpeningHoursHumanAttribute(): Collection
    {
        return new Collection(ShopService::getOpeningHoursForHuman($this->opening_hours));
    }
}
