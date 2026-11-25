<?php

namespace App\Models;

class OrderItem extends BaseModel
{
    protected $fillable = [
        'order_id', 'menu_id', 'menu_name', 'unit_price', 'quantity', 'subtotal'
    ];
    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal'   => 'decimal:2',
        'quantity'   => 'integer',
    ];

    public function order() { return $this->belongsTo(Order::class); }
    public function menu()  { return $this->belongsTo(Menu::class); }

    // OBJECT METHOD: bisa di-override oleh subclass (misal promo)
    public function calculateSubtotal(): float
    {
        return (float) $this->unit_price * (int) $this->quantity;
    }
}