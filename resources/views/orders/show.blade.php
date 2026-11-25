@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('orders.index') }}"
           class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-900 transition-colors duration-200"
           title="Kembali">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">Detail pesanan dan riwayat status</p>
        </div>
    </div>

    {{-- Info Ringkas --}}
    <div class="bg-white p-5 rounded-xl shadow-sm ring-1 ring-gray-200 mb-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
            <div class="flex items-center gap-2 text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Dibuat: <span class="text-gray-800 font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</span></span>
            </div>
            <div class="flex items-center gap-2 text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Jadwal: <span class="text-gray-800 font-medium">{{ $order->requested_delivery_at->format('d/m/Y H:i') }}</span></span>
            </div>
        </div>
        <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 ring-1 ring-amber-200">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                Status: {{ $order->order_status }}
            </span>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 ring-1 ring-blue-200">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                Bayar: {{ $order->payment_status }}
            </span>
        </div>
    </div>

    {{-- Rincian Menu --}}
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-200 mb-4 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700">Rincian Menu</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wide text-gray-400 bg-gray-50">
                        <th class="px-5 py-3 font-semibold">Menu</th>
                        <th class="px-5 py-3 font-semibold">Harga</th>
                        <th class="px-5 py-3 font-semibold">Qty</th>
                        <th class="px-5 py-3 font-semibold text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @foreach($order->items as $i)
                    <tr class="text-gray-700">
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $i->menu_name }}</td>
                        <td class="px-5 py-3">{{ \App\Models\Order::formatCurrency($i->unit_price) }}</td>
                        <td class="px-5 py-3">{{ $i->quantity }}</td>
                        <td class="px-5 py-3 text-right font-medium">{{ \App\Models\Order::formatCurrency($i->subtotal) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 bg-gray-50 border-t border-gray-100">
            <div class="ml-auto max-w-xs space-y-1.5 text-sm">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span>{{ \App\Models\Order::formatCurrency($order->subtotal) }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Biaya Kirim</span>
                    <span>{{ \App\Models\Order::formatCurrency($order->delivery_fee) }}</span>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                    <span class="font-semibold text-gray-800">Total</span>
                    <span class="font-bold text-lg text-orange-600">{{ $order->formatted_total }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Sisa Tagihan</span>
                    <span class="font-medium">{{ \App\Models\Order::formatCurrency($order->remaining_bill) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Pembayaran --}}
    @if($order->payment_status !== 'Lunas' && $order->order_status !== 'Dibatalkan')
        <form method="POST" action="{{ route('payments.store', $order) }}" enctype="multipart/form-data"
              class="bg-white p-5 rounded-xl shadow-sm ring-1 ring-gray-200 mb-4 space-y-4">
            @csrf
            <h2 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                Laporkan Pembayaran
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <select name="payment_method"
                        class="border rounded-lg p-2.5 text-sm text-gray-900 shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option>Transfer Bank</option><option>Tunai</option>
                </select>
                <input type="number" name="amount" step="0.01" min="1" placeholder="Nominal"
                       class="border rounded-lg p-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                <input type="file" name="proof" accept="image/*"
                       class="border rounded-lg p-2 text-sm text-gray-700 shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                <input name="notes" placeholder="Catatan"
                       class="border rounded-lg p-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 md:col-span-3">
            </div>
            <div class="pt-1">
                <button class="inline-flex items-center gap-2 bg-green-600 text-white font-medium text-sm px-5 py-2.5 rounded-lg shadow-sm hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Kirim
                </button>
            </div>
        </form>
    @endif

    {{-- Batalkan Pesanan --}}
    @if($order->canBeCancelledBy(auth()->user()))
        <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Batalkan pesanan?')" class="mb-4">
            @csrf
            <button class="inline-flex items-center gap-2 bg-red-600 text-white font-medium text-sm px-5 py-2.5 rounded-lg shadow-sm hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Batalkan Pesanan
            </button>
        </form>
    @endif

    {{-- Riwayat Status --}}
    <div class="bg-white p-5 rounded-xl shadow-sm ring-1 ring-gray-200">
        <h2 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Riwayat Status
        </h2>
        @forelse($order->statusHistories as $h)
            <div class="relative border-l-2 border-orange-400 pl-4 pb-4 last:pb-0">
                <span class="absolute -left-[5px] top-1.5 w-2 h-2 rounded-full bg-orange-500 ring-2 ring-white"></span>
                <p class="text-sm text-gray-800">
                    <span class="text-gray-400 text-xs">{{ $h->created_at->format('d/m/Y H:i') }}</span>
                    <span class="mx-1 text-gray-300">—</span>
                    <span class="text-gray-500">{{ $h->old_status ?? '-' }}</span>
                    <span class="mx-1 text-gray-400">→</span>
                    <span class="font-semibold">{{ $h->new_status }}</span>
                </p>
                @if($h->notes)
                    <p class="text-xs text-gray-500 mt-1 bg-gray-50 inline-block px-2 py-1 rounded">{{ $h->notes }}</p>
                @endif
            </div>
        @empty
            <p class="text-sm text-gray-500">Belum ada riwayat status.</p>
        @endforelse
    </div>
</div>
@endsection