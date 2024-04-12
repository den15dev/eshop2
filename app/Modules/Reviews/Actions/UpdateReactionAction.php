<?php

namespace App\Modules\Reviews\Actions;

use App\Modules\Reviews\Models\Reaction;
use Illuminate\Support\Facades\Auth;

class UpdateReactionAction
{
    public static function run(int $review_id, bool $up_down): \stdClass
    {
        $user_id = Auth::id();
        $response = new \stdClass();
        $response->auth = (bool) $user_id;

        if (!$user_id) return $response;

        $response->active = $up_down;

        $reactions = Reaction::where('review_id', $review_id)
            ->where('user_id', $user_id)
            ->get();

        if ($reactions->count() === 0) {
            Reaction::create(['review_id' => $review_id, 'user_id' => $user_id, 'up_down' => $up_down]);

        } elseif ($reactions->count() === 1) {
            $reaction = $reactions->first();
            if ($reaction->up_down === $up_down) {
                Reaction::where('review_id', $review_id)
                    ->where('user_id', $user_id)
                    ->delete();
                $response->active = null;

            } else {
                $reaction->up_down = $up_down;
                $reaction->save();
            }

        } else {
            foreach ($reactions as $reaction) {
                $reaction->delete();
            }
            Reaction::create(['review_id' => $review_id, 'user_id' => $user_id, 'up_down' => $up_down]);
        }

        $reactions_count = Reaction::selectRaw('up_down, count(*) as count')
            ->groupBy('up_down')
            ->where('review_id', $review_id)
            ->get();

        $response->likes = $reactions_count->firstWhere('up_down', true)?->count ?? 0;
        $response->dislikes = $reactions_count->firstWhere('up_down', false)?->count ?? 0;

        return $response;
    }
}