@extends('layouts.app')
@section('title', 'Kelola Menu')
@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Kelola Menu</h1>
    <a href="{{ route('admin.menus.create') }}" class="bg-orange-600 text-white px-4 py-2 rounded">+ Tambah Menu</a>
</div>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr><th class="p-2">Nama</th><th>Kategori</th><th>Harga</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        @forelse($menus as $m)
            <tr class="border-b">
                <td class="p-2">{{ $m->name }}</td>
                <td>{{ $m->category?->name }}</td>
                <td>{{ $m->formatted_price }}</td>
                <td>{{ $m->availability_label }}</td>
                <td class="p-2 whitespace-nowrap">
                    <a href="{{ route('admin.menus.edit', $m) }}" class="text-blue-600">Edit</a>
                    <form method="POST" action="{{ route('admin.menus.destroy', $m) }}" class="inline ml-2" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center py-4 text-gray-500">Belum ada menu.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $menus->links() }}</div>
@endsection