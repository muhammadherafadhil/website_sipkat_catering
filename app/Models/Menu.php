<?php

namespace App\Models;

use App\Contracts\Purchasable;

/**
 * OOP: POLYMORPHISM — Menu implements Purchasable.
 * Model lain (misal: PaketMenu nanti) bisa implement juga
 * dengan rumus harga berbeda, tapi PricingService tetap sama.
 */
class Menu extends BaseModel implements Purchasable
{
    protected $fillable = [
        'category_id', 'name', 'description', 'price', 'image', 'is_available'
    ];
    protected $casts = [
        'price'        => 'decimal:2',
        'is_available' => 'boolean',
    ];

    // ===== RELASI =====
    public function category()   { return $this->belongsTo(Category::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }

    // ===== IMPLEMENTASI INTERFACE Purchasable =====
    public function getUnitPrice(): float
    {
        return (float) $this->price;
    }

    public function isPurchasable(): bool
    {
        return $this->is_available && (bool) $this->category?->is_active;
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }

    // ===== SETTER =====
    public function setPriceAttribute($value): void
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Harga tidak boleh negatif.');
        }
        $this->attributes['price'] = $value;
    }

    public function setAvailable(bool $status): void
    {
        if ($status && !$this->category?->is_active) {
            throw new \DomainException('Kategori nonaktif — menu tidak bisa diaktifkan.');
        }
        $this->attributes['is_available'] = $status;
        $this->save();
    }

    // ===== GETTER =====
    public function getFormattedPriceAttribute(): string
    {
        return self::formatCurrency((float) $this->price);
    }

    public function getAvailabilityLabelAttribute(): string
    {
        return $this->is_available ? 'Tersedia' : 'Tidak Tersedia';
    }

    // ===== STATIC SCOPE =====
    public static function available()
    {
        return self::where('is_available', true)
            ->whereHas('category', fn($q) => $q->where('is_active', true));
    }

    /**
     * OVERRIDING: menu yang dipakai transaksi dinonaktifkan,
     * bukan dihapus permanen (PRD Bab 4.2).
     */
    public function delete(): bool
    {
        if ($this->orderItems()->exists()) {
            $this->is_available = false;
            return $this->save();
        }
        return parent::delete();
    }
}