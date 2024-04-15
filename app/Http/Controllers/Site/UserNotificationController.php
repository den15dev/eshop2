<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Languages\LanguageService;
use App\Modules\Orders\Models\Order;
use App\Modules\Users\NotificationService;
use App\Notifications\OrderSent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
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
/*
        $order = Order::find(2);
        $user = $order->user;
        if ($user) {
            $user->notify((new OrderSent($order))->locale($order->language_id));
        } elseif ($order->email) {
            Notification::route('mail', $order->email)
                ->notify((new OrderSent($order))->locale($order->language_id));
        }
*/
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
