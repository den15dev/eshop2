<?php

namespace App\Modules\Currencies\Models;

use App\Modules\Currencies\Sources\SourceEnum;
use App\Modules\Languages\Models\Language;
use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Currency extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'source' => SourceEnum::class,
    ];


    public static function booted(): void
    {
        static::saved(function (self $model) {
            Cache::forget('currencies');
        });

        static::updated(function (self $model) {
            Cache::forget('currencies');
        });

        static::deleted(function (self $model) {
            Cache::forget('currencies');
        });
    }


    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function skus(): HasMany
    {
        return $this->hasMany(Sku::class);
    }
}
