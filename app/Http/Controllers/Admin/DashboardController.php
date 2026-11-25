<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    /**
     * OOP: DEPENDENCY INJECTION
     * DashboardService di-inject otomatis oleh Laravel container
     * (method ini menunjukkan "object type" hint & constructor injection).
     */
    public function __construct(private DashboardService $dashboard)
    {
        // constructor injection — service siap pakai
    }

    public function index()
    {
        return view('admin.dashboard', [
            'summary'         => $this->dashboard->getSummary(),
            'recentOrders'    => $this->dashboard->getRecentOrders(),
            'pendingPayments' => $this->dashboard->getPendingPayments(),
            'unavailableMenus'=> $this->dashboard->getUnavailableMenus(),
            'recentCustomers' => $this->dashboard->getRecentCustomers(),
            'trend'           => $this->dashboard->getOrderTrend(),
            'topCustomers'    => $this->dashboard->getTopCustomers(),
        ]);
    }
}