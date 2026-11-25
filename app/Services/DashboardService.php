<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * OOP: ENCAPSULATION
 * - Semua query dashboard terkumpul di satu class.
 * - Controller tidak tahu detail query — cukup panggil method publik.
 * - Method private menyembunyikan implementasi.
 * - Konstanta untuk ambang batas & label.
 */
class DashboardService
{
    // ===== CONSTANT =====
    public const RECENT_LIMIT     = 5;
    public const LOW_STOCK_LIMIT  = 3;
    public const TOP_CUSTOMER_LIMIT = 5;
    public const CHART_DAYS       = 7;

    // ============================================================
    // PUBLIC METHODS — kontrak yang dipakai controller
    // ============================================================

    /**
     * Semua data ringkasan untuk dashboard.
     */
    public function getSummary(): array
    {
        return [
            'statusCounts'   => $this->getStatusCounts(),
            'unpaidOrders'   => $this->countUnpaidOrders(),
            'verifiedTotal'  => $this->sumVerifiedPayments(),
            'totalOrders'    => $this->countAllOrders(),
            'totalRevenue'   => $this->sumAllOrders(),
            'totalCustomers' => $this->countCustomers(),
            'pendingPayments'=> $this->countPendingPayments(),
            'unavailableMenus'=> $this->countUnavailableMenus(),
        ];
    }

    /** Jumlah pesanan per status (7 status). */
    public function getStatusCounts(): array
    {
        $raw = Order::selectRaw('order_status, COUNT(*) as total')
            ->groupBy('order_status')
            ->pluck('total', 'order_status')
            ->toArray();

        // pastikan semua status muncul (0 jika kosong)
        $result = [];
        foreach (OrderStatus::cases() as $s) {
            $result[$s->value] = $raw[$s->value] ?? 0;
        }
        return $result;
    }

    /** Pesanan terbaru (default 5). */
    public function getRecentOrders(int $limit = self::RECENT_LIMIT)
    {
        return Order::with('user')->latest()->take($limit)->get();
    }

    /** Pembayaran menunggu verifikasi (maks 5 terbaru). */
    public function getPendingPayments(int $limit = 5)
    {
        return Payment::with('order.user')
            ->where('payment_status', PaymentStatus::MENUNGGU_VERIFIKASI->value)
            ->latest()
            ->take($limit)
            ->get();
    }

    /** Menu yang menipis/tidak tersedia (unavailable). */
    public function getUnavailableMenus(int $limit = 5)
    {
        return Menu::with('category')
            ->where('is_available', false)
            ->latest()
            ->take($limit)
            ->get();
    }

    /** Pelanggan terbaru. */
    public function getRecentCustomers(int $limit = self::TOP_CUSTOMER_LIMIT)
    {
        return User::customers()->latest()->take($limit)->get();
    }

    /** Grafik pesanan 7 hari terakhir (untuk mini chart). */
    public function getOrderTrend(int $days = self::CHART_DAYS): array
    {
        $rows = Order::selectRaw('DATE(created_at) as d, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays($days - 1)->startOfDay())
            ->groupBy('d')
            ->pluck('total', 'd')
            ->toArray();

        $labels = [];
        $values = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $labels[] = now()->subDays($i)->format('d/m');
            $values[] = $rows[$date] ?? 0;
        }
        return ['labels' => $labels, 'values' => $values];
    }

    /** Top 5 pelanggan dengan total belanja terbesar. */
    public function getTopCustomers(int $limit = self::TOP_CUSTOMER_LIMIT)
    {
        return Order::select('user_id', DB::raw('SUM(total_amount) as total_belanja'), DB::raw('COUNT(*) as jumlah_pesanan'))
            ->with('user')
            ->whereHas('user', fn($q) => $q->where('role', User::ROLE_CUSTOMER))
            ->groupBy('user_id')
            ->orderByDesc('total_belanja')
            ->take($limit)
            ->get();
    }

    // ============================================================
    // PRIVATE METHODS — detail yang tidak perlu diketahui controller
    // ============================================================

    private function countUnpaidOrders(): int
    {
        return Order::whereDoesntHave('payments', fn($q) =>
            $q->where('payment_status', PaymentStatus::TERVERIFIKASI->value)
        )->count();
    }

    private function sumVerifiedPayments(): float
    {
        return (float) Payment::where('payment_status', PaymentStatus::TERVERIFIKASI->value)
            ->sum('amount');
    }

    private function countAllOrders(): int
    {
        return Order::count();
    }

    private function sumAllOrders(): float
    {
        return (float) Order::sum('total_amount');
    }

    private function countCustomers(): int
    {
        return User::customers()->count();
    }

    private function countPendingPayments(): int
    {
        return Payment::where('payment_status', PaymentStatus::MENUNGGU_VERIFIKASI->value)->count();
    }

    private function countUnavailableMenus(): int
    {
        return Menu::where('is_available', false)->count();
    }
}