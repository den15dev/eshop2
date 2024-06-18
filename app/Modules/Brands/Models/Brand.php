<?php

namespace App\Modules\Brands\Models;

use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
    use HasTranslations;

    public array $translatable = ['description'];
    protected $guarded = [];
    const IMG_DIR = 'brands';


    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
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
