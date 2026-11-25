<?php

namespace App\Models;

use App\Contracts\HasStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;

class Order extends BaseModel implements HasStatus
{
    public const STATUS_AWAL = 'Menunggu Konfirmasi';

    protected $fillable = [
        'order_number', 'user_id', 'recipient_name', 'recipient_phone',
        'delivery_address', 'requested_delivery_at',
        'subtotal', 'delivery_fee', 'total_amount',
        'order_status', 'notes', 'rejection_reason',
    ];
    protected $casts = [
        'requested_delivery_at' => 'datetime',
        'subtotal'      => 'decimal:2',
        'delivery_fee'  => 'decimal:2',
        'total_amount'  => 'decimal:2',
    ];

    // CONSTRUCTOR: default status
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (!isset($this->attributes['order_status'])) {
            $this->attributes['order_status'] = self::STATUS_AWAL;
        }
    }

    // ===== RELASI =====
    public function user()             { return $this->belongsTo(User::class); }
    public function items()            { return $this->hasMany(OrderItem::class); }
    public function payments()         { return $this->hasMany(Payment::class); }
    public function statusHistories()  { return $this->hasMany(OrderStatusHistory::class)->latest(); }

    // ===== IMPLEMENTASI HasStatus =====
    public function getStatus(): string       { return $this->order_status; }
    public function getStatusLabel(): string  { return $this->order_status; }

    // ===== GETTER (Accessor) =====
    public function getFormattedTotalAttribute(): string
    {
        return self::formatCurrency((float) $this->total_amount);
    }

    public function getVerifiedPaidAttribute(): float
    {
        return (float) $this->payments()
            ->where('payment_status', PaymentStatus::TERVERIFIKASI->value)
            ->sum('amount');
    }

    public function getRemainingBillAttribute(): float
    {
        return max(0, (float) $this->total_amount - $this->verified_paid);
    }

    public function getPaymentStatusAttribute(): string
    {
        $paid  = $this->verified_paid;
        $total = (float) $this->total_amount;
        return match(true) {
            $paid <= 0    => PaymentStatus::BELUM_DIBAYAR->value,
            $paid < $total => PaymentStatus::DIBAYAR_SEBAGIAN->value,
            default       => PaymentStatus::LUNAS->value,
        };
    }

    // ===== SETTER (Enkapsulasi perubahan state) =====
    public function setOrderStatus(string $newStatus, ?int $byUserId = null, ?string $notes = null): void
    {
        $old = $this->attributes['order_status'];
        if (!OrderStatus::canTransition($old, $newStatus)) {
            throw new \DomainException("Transisi tidak valid: {$old} → {$newStatus}");
        }
        $this->attributes['order_status'] = $newStatus;
        $this->save();
        OrderStatusHistory::log($this, $old, $newStatus, $byUserId, $notes);
    }

    public function setTotalAmount(float $subtotal, float $fee): void
    {
        if ($subtotal < 0 || $fee < 0) {
            throw new \DomainException('Nilai biaya tidak boleh negatif.');
        }
        $this->attributes['subtotal']     = $subtotal;
        $this->attributes['delivery_fee'] = $fee;
        $this->attributes['total_amount'] = $subtotal + $fee;
    }

    // ===== OBJECT METHOD =====
    public function canBeCancelledBy(User $user): bool
    {
        return $user->id === $this->user_id
            && $this->order_status === OrderStatus::MENUNGGU_KONFIRMASI->value;
    }

    // ===== OVERRIDING route key =====
    public function getRouteKeyName(): string
    {
        return 'order_number';
    }

    // ===== STATIC =====
    public static function forCustomer(User $user)
    {
        return self::where('user_id', $user->id)->latest();
    }
}