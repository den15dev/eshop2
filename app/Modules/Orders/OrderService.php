<?php

namespace App\Modules\Orders;

use App\Modules\Orders\Actions\CreateOrderAction;
use App\Modules\Orders\Actions\IsOrderOwnerAction;
use App\Modules\Orders\Enums\OrderStatus;
use App\Modules\Orders\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public const COOKIE = 'orders';

    private static ?array $cookie_order_ids = null;


    public function __construct(
        private readonly CreateOrderAction $createOrderAction,
        private readonly IsOrderOwnerAction $isOrderOwnerAction,
    ){}


    public static function setOrderIds(?string $cookie): void
    {
        self::$cookie_order_ids = $cookie ? json_decode($cookie) : null;
    }


    /**
     * Order ids from cookie.
     */
    public function getOrderIds(): ?array
    {
        return self::$cookie_order_ids;
    }


    public function createOrder(array $validated, ?int $user_id): Order
    {
        return $this->createOrderAction->run($validated, $user_id);
    }


    public static function updateUserPersonalData(?string $phone, ?string $delivery_address): void
    {
        $user = Auth::user();

        if ($user) {
            $user->phone ??= $phone;
            $user->address ??= $delivery_address;
            $user->save();
        }
    }


    public function getOrders(): ?Builder
    {
        $user_id = Auth::id();

        if ($user_id) {
            return Order::withItems()->where('user_id', $user_id);

        } elseif (self::$cookie_order_ids) {
            return Order::withItems()->whereIn('id', self::$cookie_order_ids);
        }

        return null;
    }


    public function isOrderOwner(int $order_id, ?string $cookie): bool
    {
        return $this->isOrderOwnerAction->run($order_id, $cookie);
    }


    public static function countReadyOrders(): int
    {
        $user_id = Auth::id();
        if ($user_id) {
            $query = Order::where('user_id', $user_id);
        } elseif (self::$cookie_order_ids) {
            $query = Order::whereIn('id', self::$cookie_order_ids);
        } else {
            return 0;
        }

        return $query->where('status', OrderStatus::Ready)->count();
    }


    public function createCookieString(int $order_id): string
    {
        $ids = $this->getOrderIds();
        if ($ids) {
            array_unshift($ids, $order_id);
        } else {
            $ids = [$order_id];
        }

        return json_encode($ids);
    }


    public function moveOrdersFromCookie(array $order_ids): void
    {
        $user_id = Auth::id();
        Order::whereIn('id', $order_ids)->update(['user_id' => $user_id]);
    }
}
