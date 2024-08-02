<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Users\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserNotificationController extends Controller
{
    public function __construct(
        private readonly NotificationService $notificationService,
    )
    {}


    public function index(): View
    {
        $notifications = $this->notificationService->get();
        $unread_count = $notifications->whereNull('read_at')->count();

        return view('site.pages.user-notifications', compact(
            'unread_count',
            'notifications',
        ));
    }


    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['nullable', 'uuid'],
        ]);

        $id = $validated['id'];

        $response = $id
            ? $this->notificationService->markAsRead($id)
            : $this->notificationService->markAllAsRead();

        return response()->json($response);
    }
}
