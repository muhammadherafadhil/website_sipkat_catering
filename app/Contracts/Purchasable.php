<?php

namespace App\Contracts;

/**
 * OOP: ABSTRACTION + POLYMORPHISM
 * Kontrak: setiap class yang implements interface ini WAJIB
 * menyediakan tiga method di bawah.
 *
 * Manfaat: PricingService tidak peduli objek konkret apa
 * (Menu, PaketMenu, AddOn) — selama implements Purchasable,
 * bisa diproses dengan cara yang sama.
 */
interface Purchasable
{
    public function getUnitPrice(): float;
    public function isPurchasable(): bool;
    public function getDisplayName(): string;
}