@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
{{-- ============================================================
     DASHBOARD ADMIN - DESAIN CLEAN & PROFESIONAL (REFERENSI GAMBAR)
     Logika & Fungsi 100% Tidak Diubah
============================================================ --}}

<div class="max-w-7xl mx-auto pb-12">
    
    {{-- ============ HEADER: JUDUL & TOMBOL AKSI CEPAT ============ --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Dashboard Admin</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan real-time dan seluruh data pesanan.</p>
        </div>
        <div class="flex flex-col items-end gap-2">
            <p class="text-xs text-gray-400">Terakhir diperbarui: {{ now()->format('d M Y, H.i') }}</p>
            {{-- TOMBOL AKSI CEPAT (VANILLA JS) --}}
            <button type="button" 
                    onclick="toggleAdminSidebar()"
                    class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm cursor-pointer">
                <span class="text-lg">⚡</span>
                <span>Aksi Cepat</span>
            </button>
        </div>
    </div>

    {{-- ============================================================
         1. KARTU RINGKASAN UTAMA (4 KOTAK)
    ============================================================ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        {{-- Total Pesanan --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-orange-500"></div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">TOTAL PESANAN</p>
            <p class="text-3xl font-bold text-gray-800 mb-2">{{ $summary['totalOrders'] }}</p>
            <p class="text-xs text-gray-500">Sepanjang waktu</p>
        </div>

        {{-- Menunggu Konfirmasi --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-yellow-400"></div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">MENUNGGU KONFIRMASI</p>
            <p class="text-3xl font-bold text-gray-800 mb-2">{{ $summary['statusCounts']['Menunggu Konfirmasi'] ?? 0 }}</p>
            <p class="text-xs text-gray-500">Perlu tindakan Anda</p>
        </div>

        {{-- Belum Lunas --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-red-500"></div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">BELUM LUNAS</p>
            <p class="text-3xl font-bold text-gray-800 mb-2">{{ $summary['unpaidOrders'] }}</p>
            <p class="text-xs text-gray-500">Transaksi aktif</p>
        </div>

        {{-- Pembayaran Terverifikasi --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-green-500"></div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">PEMBAYARAN TERVERIFIKASI</p>
            <p class="text-3xl font-bold text-gray-800 mb-2">{{ \App\Models\Order::formatCurrency($summary['verifiedTotal']) }}</p>
            <p class="text-xs text-gray-500">{{ $summary['pendingPayments'] }} menunggu verifikasi</p>
        </div>
    </div>

    {{-- ============================================================
         2. BANNER PERINGATAN (ITEM MEMBUTUHKAN TINDAKAN)
    ============================================================ --}}
    @php
        // Logika untuk menghitung item yang butuh tindakan (menggabungkan pesanan pending & pembayaran pending)
        $actionCount = ($summary['statusCounts']['Menunggu Konfirmasi'] ?? 0) + $summary['pendingPayments'];
    @endphp

    @if($actionCount > 0)
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center text-xl text-yellow-600">
                ⚠️
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 text-sm">{{ $actionCount }} item membutuhkan tindakan</h3>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ $summary['statusCounts']['Menunggu Konfirmasi'] ?? 0 }} pesanan baru, 
                    {{ $summary['pendingPayments'] }} pembayaran menunggu verifikasi
                </p>
            </div>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-medium text-sm px-5 py-2.5 rounded-lg transition-colors">
            Kelola Sekarang
        </a>
    </div>
    @endif

    {{-- ============================================================
         3. TABEL PESANAN TERBARU
    ============================================================ --}}
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Pesanan Terbaru</h2>
        
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-xs text-gray-500 uppercase tracking-wider bg-gray-50/50">
                            <th class="px-6 py-4 font-semibold">Nomor</th>
                            <th class="px-6 py-4 font-semibold">Tanggal</th>
                            <th class="px-6 py-4 font-semibold">Total</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Pembayaran</th>
                            <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentOrders as $o)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-sm text-gray-800">{{ $o->order_number }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $o->user->name }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $o->created_at->format('d M Y, H.i') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                                    {{ $o->formatted_total }}
                                </td>
                                <td class="px-6 py-4">
                                    {{-- Status Pill --}}
                                    @php
                                        $statusColor = match($o->order_status) {
                                            'Selesai' => 'bg-green-100 text-green-700 border-green-200',
                                            'Ditolak', 'Dibatalkan' => 'bg-red-100 text-red-700 border-red-200',
                                            'Menunggu Konfirmasi' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                            'Diproses' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            default => 'bg-gray-100 text-gray-700 border-gray-200',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border {{ $statusColor }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                                        {{ $o->order_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    {{-- Kita asumsikan status pembayaran berdasarkan order_status atau relasi (sesuai logika asli) --}}
                                    @if(in_array($o->order_status, ['Selesai', 'Dikonfirmasi']))
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border bg-green-50 text-green-700 border-green-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                                            Dibayar
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border bg-red-50 text-red-700 border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                                            Belum Dibayar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.orders.show', $o) }}" class="inline-flex items-center justify-center px-4 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                                        Kelola
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada pesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div> {{-- END MAX-W-7XL --}}


{{-- ============================================================
     PANEL SIDEBAR AKSI CEPAT (MURNI VANILLA JS)
============================================================ --}}

{{-- Overlay Gelap --}}
<div id="adminSidebarOverlay" 
     onclick="toggleAdminSidebar()"
     class="fixed inset-0 bg-black/50 z-[100] hidden opacity-0 transition-opacity duration-300"></div>

{{-- Panel Kanan --}}
<aside id="adminSidebarPanel"
       class="fixed top-0 right-0 bottom-0 w-80 max-w-[85vw] z-[110] bg-white shadow-2xl flex flex-col translate-x-full transition-transform duration-300 ease-in-out">
    
    {{-- Header Sidebar --}}
    <div class="relative bg-white border-b border-gray-200 px-5 py-5 overflow-hidden">
        <div class="relative flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center text-xl text-orange-600">
                    ⚡
                </div>
                <div>
                    <h2 class="font-bold text-base text-gray-800">Aksi Cepat</h2>
                    <p class="text-xs text-gray-500">Pintasan admin</p>
                </div>
            </div>
            {{-- Tombol Tutup --}}
            <button type="button"
                    onclick="toggleAdminSidebar()"
                    class="p-2 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors cursor-pointer"
                    aria-label="Tutup sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Menu Items --}}
    <nav class="flex-1 overflow-y-auto p-3">
        <p class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Master Data</p>
        <a href="{{ route('admin.categories.create') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors group">
            <span class="w-9 h-9 rounded-lg bg-gray-100 group-hover:bg-gray-200 flex items-center justify-center text-lg transition-colors">📁</span>
            <span class="text-sm font-medium">Kategori Baru</span>
            <span class="ml-auto text-gray-300 group-hover:text-gray-500 group-hover:translate-x-0.5 transition-all">→</span>
        </a>
        <a href="{{ route('admin.menus.create') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors group">
            <span class="w-9 h-9 rounded-lg bg-gray-100 group-hover:bg-gray-200 flex items-center justify-center text-lg transition-colors">🍱</span>
            <span class="text-sm font-medium">Menu Baru</span>
            <span class="ml-auto text-gray-300 group-hover:text-gray-500 group-hover:translate-x-0.5 transition-all">→</span>
        </a>

        <p class="px-3 py-2 mt-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Operasional</p>
        <a href="{{ route('admin.orders.index', ['status' => 'Menunggu Konfirmasi']) }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors group">
            <span class="w-9 h-9 rounded-lg bg-gray-100 group-hover:bg-gray-200 flex items-center justify-center text-lg transition-colors">📋</span>
            <span class="text-sm font-medium">Konfirmasi Pesanan</span>
            <span class="ml-auto text-gray-300 group-hover:text-gray-500 group-hover:translate-x-0.5 transition-all">→</span>
        </a>
        <a href="{{ route('admin.payments.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors group">
            <span class="w-9 h-9 rounded-lg bg-gray-100 group-hover:bg-gray-200 flex items-center justify-center text-lg transition-colors">💳</span>
            <span class="text-sm font-medium">Verifikasi Bayar</span>
            <span class="ml-auto text-gray-300 group-hover:text-gray-500 group-hover:translate-x-0.5 transition-all">→</span>
        </a>

        <p class="px-3 py-2 mt-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Lainnya</p>
        <a href="{{ route('admin.customers.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors group">
            <span class="w-9 h-9 rounded-lg bg-gray-100 group-hover:bg-gray-200 flex items-center justify-center text-lg transition-colors">👥</span>
            <span class="text-sm font-medium">Pelanggan</span>
            <span class="ml-auto text-gray-300 group-hover:text-gray-500 group-hover:translate-x-0.5 transition-all">→</span>
        </a>
        <a href="{{ route('admin.reports.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors group">
            <span class="w-9 h-9 rounded-lg bg-gray-100 group-hover:bg-gray-200 flex items-center justify-center text-lg transition-colors">📊</span>
            <span class="text-sm font-medium">Laporan</span>
            <span class="ml-auto text-gray-300 group-hover:text-gray-500 group-hover:translate-x-0.5 transition-all">→</span>
        </a>
    </nav>

    {{-- Footer Sidebar --}}
    <div class="border-t border-gray-200 px-5 py-3 bg-gray-50">
        <p class="text-xs text-gray-500 flex items-center gap-1.5">
            <span class="inline-block w-1.5 h-1.5 rounded-full bg-green-500"></span>
            Menu khusus administrator
        </p>
    </div>
</aside>

{{-- SCRIPT JAVASCRIPT MURNI UNTUK MEMBUKA / MENUTUP SIDEBAR --}}
<script>
    function toggleAdminSidebar() {
        const panel = document.getElementById('adminSidebarPanel');
        const overlay = document.getElementById('adminSidebarOverlay');
        
        // Cek apakah sedang tertutup (ada class translate-x-full)
        if (panel.classList.contains('translate-x-full')) {
            // Buka Sidebar
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
            
            overlay.classList.remove('hidden');
            // Sedikit delay agar transisi opacity berjalan mulus
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
            }, 10);
        } else {
            // Tutup Sidebar
            panel.classList.remove('translate-x-0');
            panel.classList.add('translate-x-full');
            
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            
            // Tunggu transisi selesai baru hilangkan display block-nya
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
        }
    }
</script>

@endsection