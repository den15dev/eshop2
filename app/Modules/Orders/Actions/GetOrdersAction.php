<?php

namespace App\Modules\Orders\Actions;

use App\Modules\Orders\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class GetOrdersAction
{
    public function run(?array $cookie_ids, ?int $order_id = null): Order|Builder
    {
        $user_id = Auth::id();

        $query = Order::with([
            'orderItems' => function ($q) {
                $q->join('orders', 'orders.id', 'order_items.order_id')
                    ->select(
                        'order_items.*',
                        'orders.currency_id'
                    )->with([
                    'sku' => function ($q) {
                        $q->join('products', 'products.id', 'skus.product_id')
                            ->select(
                                'skus.id',
                                'skus.name',
                                'skus.slug',
                                'products.category_id as category_id',
                            );
                    }
                ]);
            }
        ])
        ->with('shop:id,address')
        ->orderByDesc('created_at');

        if ($order_id) {
            $orders = $query->where('id', $order_id)->get();

        } elseif ($user_id) {
            $query = $query->where('user_id', $user_id);

        } elseif ($cookie_ids) {
            $query = $query->whereIn('id', $cookie_ids);
        }

        return $order_id ? $orders->first() : $query;
    }
}