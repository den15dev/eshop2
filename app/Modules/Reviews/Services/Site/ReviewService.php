<?php

namespace App\Modules\Reviews\Services\Site;

use App\Modules\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReviewService
{
    public function buildReviewsQuery(int $sku_id, ?int $user_id): Builder
    {
        return Review::withCount([
                'reactions as likes' => function ($query) { $query->where('up_down', true); },
                'reactions as dislikes' => function ($query) { $query->where('up_down', false); },
                'reactions as user_likes' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id)->where('up_down', true);
                },
                'reactions as user_dislikes' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id)->where('up_down', false);
                },
            ])
            ->with('user:id,name,image')
            ->where('sku_id', $sku_id)
            ->where(function (Builder $query) {
                $query->whereNotNull('pros')
                    ->orWhereNotNull('cons')
                    ->orWhereNotNull('comnt');
            })
            ->orderByDesc('created_at');
    }


    public function countMarks(int $sku_id): array
    {
        $marks = DB::table('reviews')
            ->select('mark')
            ->selectRaw('count(*) as marks_num')
            ->where('sku_id', $sku_id)
            ->groupBy('mark')
            ->orderBy('mark')
            ->get();

        $marks_out = [];

        for ($i = 0; $i < 5; $i++) {
            $mark_obj = $marks->firstWhere('mark', $i + 1);
            $marks_out[] = $mark_obj ? $mark_obj->marks_num : 0;
        }

        return $marks_out;
    }


    public function isReviewed(int $sku_id, ?int $user_id): bool
    {
        return $user_id && DB::table('reviews')
            ->where('sku_id', $sku_id)
            ->where('user_id', $user_id)
            ->count();
    }


    public function createReview(array $review_data): Review
    {
        DB::beginTransaction();

        try {
            $review = Review::create($review_data);
            $this->updateSkuRating($review->sku_id);
            DB::commit();

            return $review;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('events')->info('An exception caught while trying to add new review (SKU ID: ' . $review_data['sku_id'] . '): ' . $e->getMessage());
            abort(500);
        }
    }


    public function updateSkuRating(int $sku_id): void
    {
        $rating = DB::table('reviews')->selectRaw('COUNT(mark) AS vote_num, AVG(mark) AS rating')
            ->where('sku_id', $sku_id)
            ->first();

        DB::table('skus')
            ->where('id', $sku_id)
            ->update(['rating' => $rating->rating, 'vote_num' => $rating->vote_num]);
    }
}