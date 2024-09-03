<?php

namespace App\Modules\Reviews\Models;

use App\Modules\Reviews\Factories\ReactionFactory;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reaction extends Model
{
    protected $guarded = [];


    protected static function newFactory(): Factory
    {
        return ReactionFactory::new();
    }


    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
