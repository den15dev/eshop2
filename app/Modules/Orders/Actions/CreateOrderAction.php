<?php

namespace App\Modules\Orders\Actions;

use App\Modules\Cart\CartService;
use App\Modules\Cart\Models\CartItem;
use App\Modules\Currencies\CurrencyService;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateOrderAction
{
    public function __construct(
        private readonly CartService $cartService
    ){}


    public function run(array $validated, ?int $user_id): Order
    {
        $order = new Order();
        foreach ($validated as $key => $value) {
            $order->$key = $value;
        }

        $order->user_id = $user_id;
        $order->currency_id = CurrencyService::$cur_currency->id;

        $skus = $this->cartService->getCartSkus();
        $total = $this->cartService->getTotalCost($skus);

        $order->items_cost = $total->final_cost;
        $order->total_cost = $total->final_cost;

        DB::beginTransaction();

        try {
            $order->save();

            foreach ($skus as $sku) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->sku_id = $sku->id;
                $orderItem->quantity = $sku->quantity;
                $orderItem->price = $sku->final_price_converted;
                $orderItem->save();
            }

            if ($user_id) {
                CartItem::where('user_id', $user_id)->delete();
            }

            DB::commit();

            return $order;

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::channel('events')->info('An exception caught while creating the order #' . $order->id . ' (cost: ' . $total->final_cost_formatted . '): ' . $e->getMessage());
            abort(500);
        }
    }
}