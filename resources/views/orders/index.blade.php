@extends('layouts.app')
@section('title', 'Pesanan Saya')
@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pesanan Saya</h1>
            <p class="text-sm text-gray-500 mt-0.5">Riwayat dan status pesanan Anda.</p>
        </div>
        <a href="{{ route('orders.create') }}"
           class="inline-flex items-center gap-2 bg-orange-600 text-white font-medium text-sm px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-700 active:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Pesanan Baru
        </a>
    </div>

    {{-- Daftar Pesanan --}}
    <div class="space-y-3">
        @forelse($orders as $o)
            <div class="group bg-white rounded-xl shadow-sm ring-1 ring-gray-200 p-5 transition-shadow duration-300 hover:shadow-md">
                <div class="flex flex-wrap justify-between gap-4">
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            {{ $o->order_number }}
                        </p>
                        <div class="mt-1.5 space-y-0.5 text-sm text-gray-500">
                            <p class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Dibuat {{ $o->created_at->format('d/m/Y H:i') }}
                            </p>
                            <p class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Jadwal {{ $o->requested_delivery_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="text-right shrink-0">
                        <p class="font-bold text-orange-600 text-lg">{{ $o->formatted_total }}</p>
                        <div class="flex flex-col sm:flex-row sm:justify-end gap-1.5 mt-1.5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 ring-1 ring-amber-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                {{ $o->order_status }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 ring-1 ring-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                {{ $o->payment_status }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                    <a href="{{ route('orders.show', $o) }}"
                       class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200">
                        Lihat Detail
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center text-center py-16 px-4 bg-white rounded-xl ring-1 ring-gray-200">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <p class="text-gray-700 font-medium">Belum ada pesanan.</p>
                <p class="text-sm text-gray-400 mt-1">Yuk mulai pesan menu favorit Anda sekarang.</p>
                <a href="{{ route('orders.create') }}"
                   class="mt-4 inline-flex items-center gap-2 bg-orange-600 text-white font-medium text-sm px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-700 active:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Pesanan
                </a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">{{ $orders->links() }}</div>
</div>
@endsection