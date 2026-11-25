<?php

namespace App\Services;

use App\Models\Order;

class OrderNumberGenerator
{
    public const PREFIX   = 'ORD';
    public const DATE_FMT = 'Ymd';

    public static function generate(): string
    {
        $date  = now()->format(self::DATE_FMT);
        $today = Order::whereDate('created_at', now()->toDateString())->count() + 1;
        return sprintf('%s-%s-%04d', self::PREFIX, $date, $today);
    }
}