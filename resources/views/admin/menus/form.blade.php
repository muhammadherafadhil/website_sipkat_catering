@extends('layouts.app')
@section('title', $menu->exists ? 'Edit Menu' : 'Tambah Menu')
@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.menus.index') }}"
           class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-900 transition-colors duration-200"
           title="Kembali">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $menu->exists ? 'Edit Menu' : 'Tambah Menu' }}
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">
                {{ $menu->exists ? 'Perbarui informasi menu di bawah ini.' : 'Lengkapi informasi menu baru di bawah ini.' }}
            </p>
        </div>
    </div>

    {{-- Form Card --}}
    <form method="POST"
          action="{{ $menu->exists ? route('admin.menus.update', $menu) : route('admin.menus.store') }}"
          enctype="multipart/form-data"
          class="bg-white p-6 sm:p-8 rounded-xl shadow-sm ring-1 ring-gray-200 space-y-5">
        @csrf
        @if($menu->exists) @method('PUT') @endif

        {{-- Nama Menu --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Nama Menu <span class="text-red-500">*</span>
            </label>
            <input id="name" name="name" required placeholder="Contoh: Nasi Goreng Spesial, Es Teh Manis..."
                   value="{{ old('name', $menu->name) }}"
                   class="w-full border rounded-lg p-2.5 text-gray-900 placeholder-gray-400 shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Kategori --}}
        <div>
            <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Kategori <span class="text-red-500">*</span>
            </label>
            <select id="category_id" name="category_id" required
                    class="w-full border rounded-lg p-2.5 text-gray-900 shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('category_id') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
                <option value="">-- pilih kategori --</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(old('category_id', $menu->category_id) == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Harga --}}
        <div>
            <label for="price" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Harga <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-sm font-medium pointer-events-none">Rp</span>
                <input id="price" type="number" name="price" min="0" step="500" required placeholder="0"
                       value="{{ old('price', $menu->price) }}"
                       class="w-full border rounded-lg p-2.5 pl-10 text-gray-900 placeholder-gray-400 shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('price') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
            </div>
            @error('price')
                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Deskripsi
            </label>
            <textarea id="description" name="description" rows="4"
                      placeholder="Tuliskan deskripsi singkat mengenai menu ini (opsional)..."
                      class="w-full border rounded-lg p-2.5 text-gray-900 placeholder-gray-400 shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 resize-y @error('description') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">{{ old('description', $menu->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Upload Gambar --}}
        <div>
            <label for="image" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Gambar Menu
            </label>
            <label for="image"
                   class="group flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-lg p-6 cursor-pointer bg-gray-50 hover:bg-orange-50 hover:border-orange-400 transition-colors duration-200 @error('image') border-red-500 @enderror">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 group-hover:text-orange-500 transition-colors duration-200 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V19a1 1 0 001 1h16a1 1 0 001-1v-2.5M16 8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <span class="text-sm text-gray-600 group-hover:text-orange-600 transition-colors duration-200">
                    Klik untuk mengunggah gambar
                </span>
                <span class="text-xs text-gray-400 mt-0.5">PNG, JPG, WEBP, atau GIF</span>
                <input id="image" type="file" name="image" accept="image/*" class="sr-only">
                <span id="file-name" class="hidden text-xs font-medium text-orange-600 mt-2"></span>
            </label>
            @error('image')
                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Status ketersediaan --}}
        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
            <label class="flex items-start gap-3 cursor-pointer select-none">
                <input type="checkbox" name="is_available" value="1"
                       @checked(old('is_available', $menu->is_available ?? true))
                       class="mt-0.5 w-4 h-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500 focus:ring-offset-0 transition-colors duration-200">
                <span>
                    <span class="block text-sm font-medium text-gray-800">Tersedia</span>
                    <span class="block text-xs text-gray-500 mt-0.5">Menu dapat dipesan oleh pelanggan</span>
                </span>
            </label>
        </div>

        {{-- Actions --}}
        <div class="flex flex-wrap items-center gap-3 pt-2 border-t border-gray-100">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-orange-600 text-white font-medium px-5 py-2.5 rounded-lg shadow-sm hover:bg-orange-700 active:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Simpan
            </button>
            <a href="{{ route('admin.menus.index') }}"
               class="inline-flex items-center gap-2 bg-white text-gray-700 font-medium px-5 py-2.5 rounded-lg border border-gray-300 shadow-sm hover:bg-gray-50 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Batal
            </a>
        </div>
    </form>
</div>

{{-- Preview nama file (front-end only, tidak mengubah logika upload) --}}
<script>
    (function () {
        const input = document.getElementById('image');
        const fileName = document.getElementById('file-name');
        if (input && fileName) {
            input.addEventListener('change', function () {
                if (this.files && this.files.length > 0) {
                    fileName.textContent = this.files[0].name;
                    fileName.classList.remove('hidden');
                } else {
                    fileName.textContent = '';
                    fileName.classList.add('hidden');
                }
            });
        }
    })();
</script>
@endsection