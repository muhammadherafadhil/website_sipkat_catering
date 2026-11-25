@extends('layouts.app')
@section('title', 'Kelola Kategori')

@section('content')
<div class="flex flex-wrap justify-between items-center mb-4 gap-2">
    <div>
        <h1 class="text-2xl font-bold">Kelola Kategori</h1>
        <p class="text-sm text-gray-500">Total: {{ $categories->total() }} kategori</p>
    </div>
    <a href="{{ route('admin.categories.create') }}"
       class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
        + Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3">#</th>
                <th class="p-3">Nama</th>
                <th class="p-3">Deskripsi</th>
                <th class="p-3">Jumlah Menu</th>
                <th class="p-3">Status</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($categories as $i => $c)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $categories->firstItem() + $i }}</td>
                <td class="p-3 font-semibold">{{ $c->name }}</td>
                <td class="p-3 text-gray-600">{{ $c->description ?: '—' }}</td>
                <td class="p-3">{{ $c->menus()->count() }}</td>
                <td class="p-3">
                    @if($c->is_active)
                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs">Aktif</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs">Nonaktif</span>
                    @endif
                </td>
                <td class="p-3 whitespace-nowrap">
                    <a href="{{ route('admin.categories.edit', $c) }}"
                       class="text-blue-600 hover:underline">Edit</a>
                    <form method="POST"
                          action="{{ route('admin.categories.destroy', $c) }}"
                          class="inline ml-3"
                          onsubmit="return confirm('Hapus kategori ini? Jika sudah dipakai menu, akan dinonaktifkan.')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-gray-500 py-6">
                    Belum ada kategori. Klik <b>+ Tambah Kategori</b> untuk mulai.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $categories->links() }}</div>
@endsection