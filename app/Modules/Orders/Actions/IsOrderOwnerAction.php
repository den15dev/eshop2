<?php

namespace App\Modules\Orders\Actions;

use App\Modules\Orders\Enums\OrderStatus;
use App\Modules\Orders\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class IsOrderOwnerAction
{
    public function run(int $order_id, ?string $cookie): bool
    {
        $is_owner = false;
        $user_id = Auth::id();

        if ($user_id) {
            $is_owner = $this->isNewOrderExists($order_id, $user_id);

        } elseif ($cookie && in_array($order_id, json_decode($cookie))) {
            $is_owner = $this->isNewOrderExists($order_id);
        }

        return $is_owner;
    }


    private function isNewOrderExists(int $order_id, ?int $user_id = null): bool
    {
        return Order::where('id', $order_id)
            ->when($user_id, function (Builder $query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->where('status', OrderStatus::New->value)
            ->exists();
    }
}