<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentAdminController extends Controller
{
    /**
     * Menampilkan daftar pembayaran dengan relasi order dan user.
     */
    public function index()
    {
        return view('admin.payments.index', [
            'payments' => Payment::with('order.user')
                                ->latest()
                                ->paginate(15),
        ]);
    }

    /**
     * Memverifikasi pembayaran yang masuk.
     */
    public function verify(Payment $payment)
    {
        // Menggunakan Auth::user() untuk menghindari error "Undefined method 'user'" pada IDE
        $payment->verify(Auth::user());
        
        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    /**
     * Menolak pembayaran dan menyimpan alasan penolakan.
     */
    public function reject(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        // Menggunakan Auth::user() agar tipe data user terdeteksi dengan benar oleh IDE
        $payment->reject(Auth::user(), $data['reason']);
        
        return back()->with('success', 'Pembayaran berhasil ditolak.');
    }
}