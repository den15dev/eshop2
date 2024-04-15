<?php

namespace App\Modules\Users\TEMP;

use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Notification extends Model
{
//    use HasFactory;

    use HasTranslations;

    public array $translatable = ['title', 'message'];

    protected $guarded = [];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
