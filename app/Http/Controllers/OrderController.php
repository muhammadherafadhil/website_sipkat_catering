<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User; // Wajib di-import untuk pengecekan instanceof
use App\Services\OrderNumberGenerator;
use App\Services\PricingService;
use App\Services\StatusTransitionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik pelanggan yang sedang login.
     */
    public function index()
    {
        // Type narrowing: memastikan IDE dan runtime tahu ini adalah App\Models\User
        $user = Auth::user();
        if (!$user instanceof User) {
            abort(403, 'Akses tidak diizinkan.');
        }
        
        // PRD 4.1: hanya pesanan milik sendiri (melempar object User, bukan ID, untuk menghindari error tipe)
        $orders = Order::forCustomer($user)->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan halaman pembuatan pesanan.
     */
    public function create()
    {
        $menus = Menu::available()->with('category')->get();
        return view('orders.create', compact('menus'));
    }

    /**
     * Memproses penyimpanan pesanan baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'items'                 => 'required|array|min:1',
            'items.*.menu_id'       => 'required|exists:menus,id',
            'items.*.quantity'      => 'required|integer|min:1',
            'recipient_name'        => 'required|string|max:150',
            'recipient_phone'       => 'required|string|max:20',
            'delivery_address'      => 'required|string',
            'requested_delivery_at' => 'required|date|after:now',
            'notes'                 => 'nullable|string',
        ]);

        // Bangun lines untuk PricingService (Polymorphism)
        $lines = [];
        foreach ($data['items'] as $row) {
            $menu    = Menu::findOrFail($row['menu_id']);
            $lines[] = ['item' => $menu, 'qty' => (int) $row['quantity'], 'menu' => $menu];
        }

        $total = PricingService::calculateTotal($lines);

        // Type narrowing: memastikan $user adalah App\Models\User
        $user = $request->user();
        if (!$user instanceof User) {
            abort(403, 'Akses tidak diizinkan.');
        }
        $userId = $user->id; // Ambil ID dari object yang sudah terverifikasi tipenya

        DB::transaction(function () use ($data, $lines, $total, $userId) {
            $order = Order::create([
                'order_number'          => OrderNumberGenerator::generate(),
                'user_id'               => $userId,
                'recipient_name'        => $data['recipient_name'],
                'recipient_phone'       => $data['recipient_phone'],
                'delivery_address'      => $data['delivery_address'],
                'requested_delivery_at' => $data['requested_delivery_at'],
                'subtotal'              => $total['subtotal'],
                'delivery_fee'          => $total['delivery_fee'],
                'total_amount'          => $total['total'],
                'order_status'          => OrderStatus::MENUNGGU_KONFIRMASI->value,
                'notes'                 => $data['notes'] ?? null,
            ]);

            foreach ($lines as $line) {
                $menu = $line['menu'];
                OrderItem::create([
                    'order_id'   => $order->id,
                    'menu_id'    => $menu->id,
                    'menu_name'  => $menu->name,
                    'unit_price' => $menu->price,
                    'quantity'   => $line['qty'],
                    'subtotal'   => $menu->price * $line['qty'],
                ]);
            }
        });

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function show(Order $order)
    {
        // Type narrowing: memastikan $user adalah App\Models\User
        $user = Auth::user();
        if (!$user instanceof User) {
            abort(403, 'Akses tidak diizinkan.');
        }
        
        // isolasi data: bandingkan ID dari object User yang sudah terverifikasi
        abort_unless($order->user_id === $user->id, 403); 
        
        $order->load('items', 'payments', 'statusHistories.changer');
        return view('orders.show', compact('order'));
    }

    /**
     * Membatalkan pesanan oleh pelanggan.
     */
    public function cancel(Request $request, Order $order, StatusTransitionService $svc)
    {
        // Type narrowing: memastikan $user adalah App\Models\User
        $user = $request->user();
        if (!$user instanceof User) {
            abort(403, 'Akses tidak diizinkan.');
        }
        $userId = $user->id;

        // PRD 4.1: hanya pesanan status Menunggu Konfirmasi
        // Melempar object $user (bukan $userId) karena method ini kemungkinan mengharapkan tipe User
        abort_unless($order->canBeCancelledBy($user), 403);
        
        $svc->transition($order, OrderStatus::DIBATALKAN->value, $userId, 'Dibatalkan oleh pelanggan');
        
        return back()->with('success', 'Pesanan dibatalkan.');
    }
}