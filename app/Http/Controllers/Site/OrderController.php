<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Cart\CartService;
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
        $orders = $this->orderService->getOrders()->paginate(10);

        return view('site.pages.orders', compact('orders'));
    }


    public function store(OrderRequest $request)
    {
        $user_id = Auth::id();
        $order = $this->orderService->createOrder($request->validated(), $user_id);
        Cookie::expire(CartService::COOKIE);

        if (!$user_id) {
            $cookie = $this->orderService->createCookieString($order->id);

            return redirect()
                ->route('orders.new', $order->id)
                ->withCookie(Cookie::forever(OrderService::COOKIE, $cookie));
        }

        return redirect()->route('orders.new', $order->id);
    }


    public function new(int $order_id): View
    {
        $order = $this->orderService->getOrders($order_id);

        return view('site.pages.order-new', compact(
            'order',
        ));
    }
}
