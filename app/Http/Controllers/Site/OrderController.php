<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Cart\CartService;
use App\Modules\Log\LogService;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\OrderService;
use App\Modules\Orders\Requests\OrderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService
    ){}


    public function index(): View
    {
        $orders = $this->orderService->getOrders()?->paginate(10);

        return view('site.pages.orders', compact('orders'));
    }


    public function store(OrderRequest $request)
    {
        $user_id = Auth::id();
        $validated = $request->validated();
        $order = $this->orderService->createOrder($validated, $user_id);
        Cookie::expire(CartService::COOKIE);

        LogService::writeEventLog(
            'new-order',
            [
                'id' => $order->id,
                'cost' => $order->total_cost_formatted,
                'user_id' => $user_id,
                'name' => $order->name,
            ]
        );

        if ($user_id) {
            $delivery_address = $validated['delivery_address'] ?? null;
            OrderService::updateUserPersonalData($validated['phone'], $delivery_address);

        } else {
            $cookie = $this->orderService->createCookieString($order->id);

            return redirect()
                ->route('orders.new', $order->id)
                ->withCookie(Cookie::forever(OrderService::COOKIE, $cookie));
        }

        return redirect()->route('orders.new', $order->id);
    }


    public function new(int $order_id): View
    {
        $order = Order::withItems()->firstWhere('id', $order_id);

        return view('site.pages.order-new', compact(
            'order',
        ));
    }
}
