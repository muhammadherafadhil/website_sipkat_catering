@extends('layouts.app')
@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.categories.index') }}"
           class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-900 transition-colors duration-200"
           title="Kembali">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $category->exists ? 'Edit Kategori' : 'Tambah Kategori' }}
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">
                {{ $category->exists ? 'Perbarui informasi kategori di bawah ini.' : 'Lengkapi informasi kategori baru di bawah ini.' }}
            </p>
        </div>
    </div>

    {{-- Form Card --}}
    <form method="POST"
          action="{{ $category->exists
                    ? route('admin.categories.update', $category)
                    : route('admin.categories.store') }}"
          class="bg-white p-6 sm:p-8 rounded-xl shadow-sm ring-1 ring-gray-200 space-y-6">
        @csrf
        @if($category->exists) @method('PUT') @endif

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Nama Kategori <span class="text-red-500">*</span>
            </label>
            <input type="text" id="name" name="name" required maxlength="100"
                   value="{{ old('name', $category->name) }}"
                   placeholder="Contoh: Minuman, Makanan..."
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

        {{-- Deskripsi --}}
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Deskripsi
            </label>
            <textarea id="description" name="description" rows="4"
                      placeholder="Tuliskan deskripsi singkat mengenai kategori ini (opsional)..."
                      class="w-full border rounded-lg p-2.5 text-gray-900 placeholder-gray-400 shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 resize-y">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Status aktif --}}
        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
            <label class="flex items-start gap-3 cursor-pointer select-none">
                <input type="checkbox" name="is_active" value="1"
                       @checked(old('is_active', $category->is_active ?? true))
                       class="mt-0.5 w-4 h-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500 focus:ring-offset-0 transition-colors duration-200">
                <span>
                    <span class="block text-sm font-medium text-gray-800">Kategori aktif</span>
                    <span class="block text-xs text-gray-500 mt-0.5">Tampil di katalog</span>
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
            <a href="{{ route('admin.categories.index') }}"
               class="inline-flex items-center gap-2 bg-white text-gray-700 font-medium px-5 py-2.5 rounded-lg border border-gray-300 shadow-sm hover:bg-gray-50 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Batal
            </a>
        </div>
    </form>
</div>
@endsection