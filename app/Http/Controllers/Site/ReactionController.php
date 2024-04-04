<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Reviews\Services\Site\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function store(
        Request $request,
        ReviewService $reviewService,
    ): JsonResponse
    {
        $review_id = intval($request->review_id);
        $up_down = $request->up_down;

        $response = $reviewService->updateReaction($review_id, $up_down);

        return response()->json($response);
    }
}
