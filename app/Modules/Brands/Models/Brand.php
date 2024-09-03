<?php

namespace App\Modules\Brands\Models;

use App\Modules\Brands\Factories\BrandFactory;
use App\Modules\Common\CommonService;
use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
    use HasTranslations;

    public array $translatable = ['description'];
    protected $guarded = [];
    const IMG_DIR = 'brands';


    protected static function newFactory(): Factory
    {
        return BrandFactory::new();
    }


    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::createFromDate($value)->tz(CommonService::$timezone),
        );
    }


    public function getUrlAttribute(): ?string
    {
        return $this->slug ? route('brand', $this->slug) : null;
    }


    public function getImageUrlAttribute(): ?string
    {
        $url = null;
        $types = ['svg', 'png'];
        $dir = Storage::disk('images')->path(self::IMG_DIR);
        $relative_base = config('filesystems.disks.images.relative_url') . '/' . self::IMG_DIR;

        foreach ($types as $ext) {
            if (file_exists($dir . '/' . $this->slug . '.' . $ext)) {
                $url = asset($relative_base . '/' . $this->slug . '.' . $ext);
                break;
            }
        }

        return $url;
    }
}
