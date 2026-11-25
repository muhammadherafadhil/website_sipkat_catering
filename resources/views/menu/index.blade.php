@extends('layouts.app')
@section('title', 'Katalog Menu')
@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Katalog Menu</h1>
        <p class="text-sm text-gray-500 mt-1">Temukan menu favorit Anda berdasarkan kategori atau kata kunci.</p>
    </div>

    {{-- Filter --}}
    <form method="GET"
          class="mb-8 flex flex-wrap items-center gap-2 bg-white p-3 rounded-xl shadow-sm ring-1 ring-gray-200">
        <div class="relative">
            <select name="category"
                    class="appearance-none border border-gray-300 rounded-lg pl-3 pr-9 py-2.5 text-sm text-gray-900 bg-white shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        <div class="relative flex-1 min-w-[200px]">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
            </svg>
            <input name="q" value="{{ request('q') }}" placeholder="Cari menu..."
                   class="w-full border border-gray-300 rounded-lg pl-9 pr-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
        </div>

        <button class="inline-flex items-center gap-2 bg-orange-600 text-white font-medium text-sm px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-700 active:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
            </svg>
            Cari
        </button>
    </form>

    {{-- Grid Menu --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($menus as $menu)
            <div class="group bg-white rounded-xl shadow-sm ring-1 ring-gray-200 overflow-hidden flex flex-col transition-shadow duration-300 hover:shadow-lg">
                @if($menu->image)
                    <div class="aspect-[4/3] w-full overflow-hidden bg-gray-50">
                        <img src="{{ asset('storage/'.$menu->image) }}"
                             alt="{{ $menu->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                @endif
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="font-semibold text-gray-900 leading-snug">{{ $menu->name }}</h3>
                    <p class="text-xs font-medium text-gray-500 mt-1 inline-flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5a2 2 0 011.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        {{ $menu->category?->name }}
                    </p>
                    <p class="text-orange-600 font-bold text-lg mt-3">{{ $menu->formatted_price }}</p>
                    <a href="{{ route('menu.show', $menu) }}"
                       class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200 self-start">
                        Detail
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="flex flex-col items-center justify-center text-center py-16 px-4 bg-white rounded-xl ring-1 ring-gray-200">
                    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-700 font-medium">Tidak ada menu.</p>
                    <p class="text-sm text-gray-400 mt-1">Coba ubah kategori atau kata kunci pencarian Anda.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">{{ $menus->links() }}</div>
</div>
@endsection