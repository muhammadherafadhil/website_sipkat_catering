<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\StatusTransitionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderAdminController extends Controller
{
    /**
     * Menampilkan daftar pesanan dengan fitur filter dan pagination.
     */
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }
        
        // Filter berdasarkan tanggal mulai
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        
        // Filter berdasarkan tanggal akhir
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        return view('admin.orders.index', [
            'orders'   => $query->paginate(15)->withQueryString(),
            'statuses' => OrderStatus::values(), // Pastikan method values() ada di Enum Anda
        ]);
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function show(Order $order)
    {
        // Eager load relasi yang dibutuhkan untuk halaman detail
        $order->load('items', 'payments', 'statusHistories.changer', 'user');
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Mengonfirmasi pesanan yang sedang menunggu.
     */
    public function confirm(Order $order, StatusTransitionService $svc)
    {
        // Menggunakan argumen posisional (urutan) + Auth::id() agar kompatibel & bebas error IDE
        $svc->transition($order, OrderStatus::DIKONFIRMASI->value, Auth::id(), 'Dikonfirmasi oleh admin');
        
        return back()->with('success', 'Pesanan berhasil dikonfirmasi.');
    }

    /**
     * Menolak pesanan dan menyimpan alasan penolakan.
     */
    public function reject(Request $request, Order $order, StatusTransitionService $svc)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        // Simpan alasan penolakan ke dalam kolom order
        $order->rejection_reason = $request->rejection_reason;
        $order->save();

        // Menggunakan argumen posisional (urutan) + Auth::id()
        $svc->transition($order, OrderStatus::DITOLAK->value, Auth::id(), $request->rejection_reason);

        return back()->with('success', 'Pesanan berhasil ditolak.');
    }

    /**
     * Mengupdate status pesanan secara manual oleh admin.
     */
    public function updateStatus(Request $request, Order $order, StatusTransitionService $svc)
    {
        $data = $request->validate([
            'status' => 'required|string'
        ]);

        try {
            // Menggunakan argumen posisional (urutan) + Auth::id()
            $svc->transition($order, $data['status'], Auth::id(), 'Update oleh admin');
            
            return back()->with('success', 'Status pesanan berhasil diperbarui.');
            
        } catch (\DomainException $e) {
            // Jika transisi status tidak valid, kembalikan error dan pertahankan input user
            return back()
                ->withErrors(['status' => $e->getMessage()])
                ->withInput();
        }
    }
}