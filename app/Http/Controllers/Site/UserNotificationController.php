<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Users\NotificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserNotificationController extends Controller
{
    public function index(
        NotificationService $notificationService
    ): View {
        $notifications = $notificationService->get();

        $unread_count = $notifications->where('is_unread', true)->count();

        return view('site.pages.user-notifications', compact(
            'unread_count',
            'notifications',
        ));
    }
}
