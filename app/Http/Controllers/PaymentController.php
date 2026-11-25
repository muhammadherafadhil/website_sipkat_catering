<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Memproses penyimpanan pembayaran baru untuk pesanan.
     */
    public function store(Request $request, Order $order)
    {
        // Menggunakan Auth::id() untuk menghindari error "Undefined method 'id'" pada IDE
        abort_unless($order->user_id === Auth::id(), 403);

        $data = $request->validate([
            'payment_method' => 'required|in:Transfer Bank,Tunai',
            'amount'         => 'required|numeric|min:0.01',
            'notes'          => 'nullable|string',
            'proof'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // BR-13: pembayaran baru tidak boleh melebihi sisa tagihan
        $totalPending = $order->payments()
            ->whereIn('payment_status', [
                PaymentStatus::MENUNGGU_VERIFIKASI->value,
                PaymentStatus::TERVERIFIKASI->value,
            ])->sum('amount');

        if ($totalPending + $data['amount'] > $order->total_amount) {
            return back()->withErrors(['amount' => 'Nominal melebihi sisa tagihan.']);
        }

        $proofPath = $request->hasFile('proof')
            ? $request->file('proof')->store('proofs', 'public')
            : null;

        Payment::create([
            'order_id'       => $order->id,
            'payment_method' => $data['payment_method'],
            'amount'         => $data['amount'],
            'notes'          => $data['notes'] ?? null,
            'proof_path'     => $proofPath,
            'payment_status' => PaymentStatus::MENUNGGU_VERIFIKASI->value,
        ]);

        return back()->with('success', 'Pembayaran dilaporkan, menunggu verifikasi admin.');
    }
}