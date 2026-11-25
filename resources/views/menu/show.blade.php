@extends('layouts.app')
@section('title', $menu->name)
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 overflow-hidden">
        <div class="flex flex-col md:flex-row">

            {{-- Gambar --}}
            @if($menu->image)
                <div class="md:w-2/5 shrink-0 bg-gray-50">
                    <div class="aspect-square w-full overflow-hidden">
                        <img src="{{ asset('storage/'.$menu->image) }}"
                             alt="{{ $menu->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                </div>
            @endif

            {{-- Konten --}}
            <div class="flex-1 p-6 sm:p-8 flex flex-col">

                {{-- Kategori --}}
                <span class="inline-flex items-center self-start gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-orange-50 text-orange-700 ring-1 ring-orange-200 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5a2 2 0 011.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    {{ $menu->category?->name }}
                </span>

                {{-- Nama --}}
                <h1 class="text-3xl font-bold text-gray-900 leading-tight">{{ $menu->name }}</h1>

                {{-- Harga --}}
                <p class="text-orange-600 text-2xl font-bold mt-3">{{ $menu->formatted_price }}</p>

                {{-- Deskripsi --}}
                @if($menu->description)
                    <p class="mt-5 text-gray-600 leading-relaxed">{{ $menu->description }}</p>
                @endif

                {{-- Status --}}
                <div class="mt-5 flex items-center gap-2 text-sm">
                    <span class="text-gray-500">Status:</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                        {{ $menu->is_available ? 'bg-green-50 text-green-700 ring-1 ring-green-200' : 'bg-red-50 text-red-700 ring-1 ring-red-200' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $menu->is_available ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        {{ $menu->availability_label }}
                    </span>
                </div>

                {{-- Aksi --}}
                <div class="mt-auto pt-6">
                    @auth
                        @if(auth()->user()->isCustomer() && $menu->isPurchasable())
                            <a href="{{ route('orders.create') }}"
                               class="inline-flex items-center justify-center gap-2 w-full sm:w-auto bg-orange-600 text-white font-medium px-6 py-3 rounded-lg shadow-sm hover:bg-orange-700 active:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Pesan Sekarang
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center gap-2 w-full sm:w-auto bg-orange-600 text-white font-medium px-6 py-3 rounded-lg shadow-sm hover:bg-orange-700 active:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Login untuk Pesan
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection