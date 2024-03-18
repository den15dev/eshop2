<?php

namespace App\Modules\Languages\Models;

use App\Modules\Currencies\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;

class Language extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
        'default' => 'boolean',
        'fallback' => 'boolean',
    ];


    public static function booted(): void
    {
        static::saved(function (self $model) {
            Cache::forget('languages');
        });

        static::updated(function (self $model) {
            Cache::forget('languages');
        });

        static::deleted(function (self $model) {
            Cache::forget('languages');
        });
    }


    public function currency(): HasOne
    {
        return $this->hasOne(Currency::class);
    }
}
