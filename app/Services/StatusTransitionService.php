<?php

namespace App\Services;

use App\Models\Order;

class StatusTransitionService
{
    public function transition(Order $order, string $newStatus, ?int $byUserId = null, ?string $notes = null): Order
    {
        $order->setOrderStatus($newStatus, $byUserId, $notes); // validasi ada di model
        return $order;
    }
}