<?php

namespace App\Http\Middleware;

use App\Modules\Orders\OrderService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOrderOwner
{
    public function __construct(
        private readonly OrderService $orderService
    ){}


    public function handle(Request $request, Closure $next): Response
    {
        $order_id = $request->route('order_id');
        $cookie = $request->cookie(OrderService::COOKIE);

        abort_unless($this->orderService->isOrderOwner($order_id, $cookie), 404);

        return $next($request);
    }
}
