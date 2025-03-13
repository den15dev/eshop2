<?php

namespace App\Modules\Settings\Models;

use App\Modules\Settings\Enums\DataType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasTranslations;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    protected $casts = [
        'data_type' => DataType::class,
    ];

    public array $translatable = [
        'name',
        'description',
    ];


    public static function booted(): void
    {
        static::saved(function (self $model) {
            Cache::forget('settings');
        });

        static::updated(function (self $model) {
            Cache::forget('settings');
        });

        static::deleted(function (self $model) {
            Cache::forget('settings');
        });
    }


    protected function val(): Attribute
    {
        return Attribute::make(
            get: function (string $value, array $attributes) {
                return match ($attributes['data_type']) {
                    DataType::Integer->value => (int) $value,
                    DataType::Boolean->value => filter_var($value, FILTER_VALIDATE_BOOLEAN),
                    DataType::Array->value => json_decode($value, true),
                    default => $value,
                };
            },

            set: function (mixed $value, array $attributes) {
                return match ($attributes['data_type']) {
                    DataType::Array->value => json_encode($value),
                    default => (string) $value,
                };
            }
        );
    }


    public function getArrayTextAttribute(): string
    {
        if ($this->data_type === DataType::Array) {
            return implode("\n", $this->val);
        }

        return $this->val;
    }
}
