<?php

namespace App\Services;

use App\Contracts\Purchasable;

/**
 * OOP: POLYMORPHISM
 * Method calculateTotal() menerima array berisi objek apa pun
 * yang implements Purchasable — tidak peduli tipe konkretnya.
 */
class PricingService
{
    public static function deliveryFee(): float
    {
        return (float) config('sipkat.delivery_fee', 10000);
    }

    /**
     * @param array<int, array{item: Purchasable, qty: int}> $lines
     */
    public static function calculateTotal(array $lines): array
    {
        $subtotal = 0;
        foreach ($lines as $line) {
            if (!$line['item']->isPurchasable()) {
                throw new \RuntimeException(
                    "{$line['item']->getDisplayName()} tidak tersedia."
                );
            }
            $subtotal += $line['item']->getUnitPrice() * (int) $line['qty'];
        }
        $fee = self::deliveryFee();
        return [
            'subtotal'     => $subtotal,
            'delivery_fee' => $fee,
            'total'        => $subtotal + $fee,
        ];
    }
}