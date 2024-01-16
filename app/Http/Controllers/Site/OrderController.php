<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = new \stdClass();
        $order->id = 23;

        return redirect()->route('orders.new', $order->id);
    }


    public function new(int $order_id): View
    {
        return view('site.pages.order-new');
    }
}
