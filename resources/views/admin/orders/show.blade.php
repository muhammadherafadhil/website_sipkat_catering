@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-900 transition-colors duration-200"
           title="Kembali">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">Detail dan status pesanan pelanggan</p>
        </div>
    </div>

    {{-- Info Pesanan --}}
    <div class="bg-white p-6 rounded-xl shadow-sm ring-1 ring-gray-200 mb-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400 mb-1">Pelanggan</p>
                <p class="text-gray-800 font-medium">{{ $order->user->name }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400 mb-1">Penerima</p>
                <p class="text-gray-800">{{ $order->recipient_name }} <span class="text-gray-500">({{ $order->recipient_phone }})</span></p>
            </div>
            <div class="sm:col-span-2">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400 mb-1">Alamat Pengiriman</p>
                <p class="text-gray-800">{{ $order->delivery_address }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400 mb-1">Jadwal Pengiriman</p>
                <p class="text-gray-800">{{ $order->requested_delivery_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400 mb-1">Status</p>
                <div class="flex flex-wrap items-center gap-2 mt-1">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 ring-1 ring-amber-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        {{ $order->order_status }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 ring-1 ring-blue-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        Bayar: {{ $order->payment_status }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Rincian Item --}}
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-200 mb-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">Rincian Item</h2>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($order->items as $i)
                <div class="flex justify-between items-center px-6 py-3 text-sm">
                    <span class="text-gray-800">
                        {{ $i->menu_name }}
                        <span class="text-gray-400 font-medium">× {{ $i->quantity }}</span>
                    </span>
                    <span class="text-gray-700 font-medium">{{ \App\Models\Order::formatCurrency($i->subtotal) }}</span>
                </div>
            @endforeach
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
            <span class="text-sm font-semibold text-gray-700">Total</span>
            <span class="text-lg font-bold text-orange-600">{{ $order->formatted_total }}</span>
        </div>
    </div>

    {{-- Aksi --}}
    @if($order->order_status === 'Menunggu Konfirmasi')
        <div class="bg-white p-6 rounded-xl shadow-sm ring-1 ring-gray-200 space-y-4">
            <h2 class="text-sm font-semibold text-gray-700">Tindakan</h2>
            <div class="flex flex-wrap items-start gap-3">
                <form method="POST" action="{{ route('admin.orders.confirm', $order) }}" class="inline">@csrf
                    <button class="inline-flex items-center gap-2 bg-green-600 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Konfirmasi
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.orders.reject', $order) }}" class="inline-flex flex-wrap items-center gap-2">@csrf
                    <input name="rejection_reason" required placeholder="Alasan penolakan"
                           class="border rounded-lg p-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('rejection_reason') border-red-500 @enderror">
                    <button class="inline-flex items-center gap-2 bg-red-600 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Tolak
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="bg-white p-6 rounded-xl shadow-sm ring-1 ring-gray-200">
            <h2 class="text-sm font-semibold text-gray-700 mb-3">Perbarui Status</h2>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="flex flex-wrap items-center gap-2">@csrf
                <select name="status"
                        class="border rounded-lg p-2.5 text-sm text-gray-900 shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @foreach(\App\Enums\OrderStatus::values() as $s)
                        <option value="{{ $s }}">{{ $s }}</option>
                    @endforeach
                </select>
                <button class="inline-flex items-center gap-2 bg-blue-600 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Update
                </button>
            </form>
        </div>
    @endif
</div>
@endsection