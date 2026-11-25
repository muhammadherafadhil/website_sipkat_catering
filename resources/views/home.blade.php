@extends('layouts.app')
@section('title', 'SIPKAT — Katering Online')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-16">

    {{-- ================= HERO SECTION ================= --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
        {{-- Teks Kiri --}}
        <div class="order-2 lg:order-1">
            {{-- Badge kecil --}}
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-orange-50 text-orange-700 ring-1 ring-orange-200 mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                Katering rumahan · sejak 2023
            </span>

            {{-- Headline --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 leading-[1.1]">
                Pesan <span class="italic text-orange-600">katering</span><br>
                lebih mudah, hangat,<br>
                dan tepat waktu.
            </h1>

            <p class="mt-5 text-base sm:text-lg text-gray-600 leading-relaxed max-w-xl">
                Pilih menu favorit keluarga, tentukan jumlah, isi alamat dan jadwal — sistem menghitung total otomatis dan pesanan Anda langsung terhubung ke dapur kami.
            </p>

            {{-- CTA --}}
            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="{{ route('menu.index') }}"
                   class="inline-flex items-center gap-2 bg-orange-600 text-white font-semibold px-6 py-3 rounded-xl shadow-sm hover:bg-orange-700 active:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                    Lihat Menu
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2 bg-white text-gray-800 font-semibold px-6 py-3 rounded-xl border border-gray-300 shadow-sm hover:bg-gray-50 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-colors duration-200">
                    Masuk Akun
                </a>
            </div>

            {{-- Stats --}}
            <div class="mt-10 grid grid-cols-3 gap-4 max-w-md pt-6 border-t border-gray-200">
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['categories'] }}</p>
                    <p class="text-xs uppercase tracking-wide text-gray-500 mt-0.5">Kategori</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['menus'] }}</p>
                    <p class="text-xs uppercase tracking-wide text-gray-500 mt-0.5">Menu Tersedia</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">3–12</p>
                    <p class="text-xs uppercase tracking-wide text-gray-500 mt-0.5">Jam Pengiriman</p>
                </div>
            </div>
        </div>

        {{-- Gambar Kanan --}}
        <div class="order-1 lg:order-2 relative">
            <div class="absolute -inset-4 bg-gradient-to-tr from-orange-100 via-yellow-50 to-transparent rounded-3xl blur-2xl opacity-70 pointer-events-none"></div>
            <div class="relative rounded-3xl overflow-hidden shadow-2xl ring-1 ring-gray-200 aspect-[4/5] sm:aspect-[5/4] lg:aspect-[4/5]">
                <img src="https://super45gourmet.com/wp-content/uploads/2024/12/regbuffet-icon_executive-e1733388147853.jpg"
                     alt="Hidangan katering SIPKAT"
                     class="w-full h-full object-cover">
                {{-- Floating card --}}
                <div class="absolute bottom-4 left-4 right-4 sm:left-4 sm:right-auto bg-white/90 backdrop-blur-md rounded-2xl shadow-lg ring-1 ring-white/60 p-3 flex items-center gap-3 max-w-xs">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-gray-900 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            Tersedia hari ini
                        </p>
                        <p class="text-xs text-gray-500">Diantar ke alamat Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= MENU UNGGULAN ================= --}}
    <section>
        <div class="flex flex-wrap items-end justify-between gap-3 mb-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-orange-600">Paling Dipesan</p>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Menu unggulan</h2>
                <p class="text-sm text-gray-500 mt-1">Pilihan terlaris dengan bahan segar setiap hari.</p>
            </div>
            <a href="{{ route('menu.index') }}"
               class="inline-flex items-center gap-1 text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors duration-200">
                Lihat semua
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- PERBAIKAN: batasi maksimal 4 menu unggulan yang tampil --}}
            @foreach($featured->take(4) as $m)
                <div class="group bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 overflow-hidden flex flex-col transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                    {{-- Gambar (pakai kategori sebagai ilustrasi dinamis) --}}
                    <div class="aspect-[4/3] w-full bg-gray-100 overflow-hidden relative">
                        {{-- Gambar diambil dari data menu ($m) agar sama dengan katalog --}}
                        <img src="{{ $m->image_url ?? ($m->image ? asset('storage/' . $m->image) : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=800&auto=format&fit=crop') }}"
                             alt="{{ $m->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        {{-- Badge kategori --}}
                        <span class="absolute top-3 left-3 inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold uppercase tracking-wide bg-white/90 backdrop-blur text-gray-800 ring-1 ring-white/60 shadow-sm">
                            {{ $m->category?->name }}
                        </span>
                    </div>

                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-gray-900 leading-snug">{{ $m->name }}</h3>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">Pilihan terlaris dengan bahan segar pilihan setiap hari.</p>

                        <div class="mt-auto pt-4 flex items-center justify-between gap-2">
                            <p class="text-orange-600 font-bold">{{ $m->formatted_price }}</p>
                            <a href="{{ route('menu.show', $m) }}"
                               class="inline-flex items-center gap-1 bg-orange-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-sm hover:bg-orange-700 active:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                                Detail
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ================= FITUR (3 KARTU) ================= --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 p-6">
            <div class="w-11 h-11 rounded-xl bg-orange-50 ring-1 ring-orange-100 flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Pesan terstruktur</h3>
            <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">Setiap pesanan punya nomor urut, menu, alamat, dan jadwal yang dicatat lengkap.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 p-6">
            <div class="w-11 h-11 rounded-xl bg-orange-50 ring-1 ring-orange-100 flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m-6 4h6m-6 4h4M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Total otomatis</h3>
            <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">Subtotal dari daftar harga, ditambah biaya pengiriman tetap — bebas salah hitung.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 p-6">
            <div class="w-11 h-11 rounded-xl bg-orange-50 ring-1 ring-orange-100 flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900">Terhubung real-time</h3>
            <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">Setiap pesanan langsung masuk ke dashboard admin tanpa perlu refresh.</p>
        </div>
    </section>

    {{-- ================= KONTAK ================= --}}
    <section class="bg-gray-900 rounded-2xl p-8 sm:p-10 text-white">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1">
                <div class="inline-flex items-center gap-2 mb-3">
                    <span class="w-8 h-8 rounded-lg bg-orange-500 flex items-center justify-center font-bold text-sm">S</span>
                    <span class="font-bold text-lg">SIPKAT</span>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Sistem informasi Pemesanan Katering. Prototipe untuk kebutuhan demo. Semua data di aplikasi ini bersifat contoh.
                </p>
            </div>

            <div>
                <h4 class="text-xs font-semibold uppercase tracking-widest text-gray-500 mb-3">Hubungi Kami</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        0812-3456-7890
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        admin@sipkat.test
                    </li>
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Jl. AP Pettarani No. 12, Makassar, Sulawesi Selatan, Indonesia
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-semibold uppercase tracking-widest text-gray-500 mb-3">Jam Layanan</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Senin–Sabtu, 07:00–20:00
                    </li>
                    <li class="flex items-center gap-2 text-gray-400">
                        Minggu: Tutup
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-8 pt-6 border-t border-gray-800 text-xs text-gray-500 flex flex-wrap justify-between gap-2">
            <p>&copy; {{ date('Y') }} SIPKAT.</p>
            <p>Sipkat Katering Makassar.</p>
        </div>
    </section>
</div>
@endsection