<?php

namespace App\Models;

class OrderStatusHistory extends BaseModel
{
    protected $fillable = ['order_id', 'changed_by', 'old_status', 'new_status', 'notes'];

    public function order()   { return $this->belongsTo(Order::class); }
    public function changer() { return $this->belongsTo(User::class, 'changed_by'); }

    public static function log(Order $order, ?string $old, string $new, ?int $by = null, ?string $notes = null): self
    {
        return self::create([
            'order_id'   => $order->id,
            'changed_by' => $by,
            'old_status' => $old,
            'new_status' => $new,
            'notes'      => $notes,
        ]);
    }
}