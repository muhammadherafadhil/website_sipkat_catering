<?php

namespace App\Models;

use App\Enums\PaymentStatus;

class Payment extends BaseModel
{
    protected $fillable = [
        'order_id', 'payment_method', 'amount', 'proof_path',
        'payment_status', 'verified_by', 'verified_at', 'notes',
    ];
    protected $casts = [
        'amount'      => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    public function order()    { return $this->belongsTo(Order::class); }
    public function verifier() { return $this->belongsTo(User::class, 'verified_by'); }

    // SETTER
    public function setAmountAttribute($value): void
    {
        if ((float) $value <= 0) {
            throw new \InvalidArgumentException('Nominal harus > 0.');
        }
        $this->attributes['amount'] = $value;
    }

    // GETTER
    public function getFormattedAmountAttribute(): string
    {
        return self::formatCurrency((float) $this->amount);
    }

    // OBJECT METHOD
    public function verify(User $admin, ?string $notes = null): void
    {
        $this->payment_status = PaymentStatus::TERVERIFIKASI->value;
        $this->verified_by    = $admin->id;
        $this->verified_at    = now();
        $this->notes          = $notes;
        $this->save();
    }

    public function reject(User $admin, string $reason): void
    {
        $this->payment_status = PaymentStatus::DITOLAK->value;
        $this->verified_by    = $admin->id;
        $this->verified_at    = now();
        $this->notes          = $reason;
        $this->save();
    }

    public static function pending()
    {
        return self::where('payment_status', PaymentStatus::MENUNGGU_VERIFIKASI->value);
    }
}