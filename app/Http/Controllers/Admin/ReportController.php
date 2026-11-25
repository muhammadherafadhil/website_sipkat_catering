<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'from' => 'nullable|date',
            'to'   => 'nullable|date|after_or_equal:from',
        ]);

        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to   = $request->input('to',   now()->toDateString());

        $orders = Order::with('user')
            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->when($request->filled('status'), fn($q) => $q->where('order_status', $request->status))
            ->get();

        $verifiedPayments = Payment::where('payment_status', PaymentStatus::TERVERIFIKASI->value)
            ->whereBetween('verified_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->sum('amount');

        $totalOrders = $orders->sum('total_amount');
        $sisa        = $totalOrders - $verifiedPayments;

        return view('admin.reports.index', compact(
            'orders', 'verifiedPayments', 'totalOrders', 'sisa', 'from', 'to'
        ));
    }
}