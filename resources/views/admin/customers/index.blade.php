@extends('layouts.app')
@section('title', 'Daftar Pelanggan')
@section('content')
<h1 class="text-2xl font-bold mb-4">Daftar Pelanggan</h1>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr><th class="p-2">Nama</th><th>Email</th><th>Telepon</th><th>Terdaftar</th></tr>
        </thead>
        <tbody>
        @forelse($customers as $c)
            <tr class="border-b">
                <td class="p-2">{{ $c->name }}</td>
                <td>{{ $c->email }}</td>
                <td>{{ $c->phone }}</td>
                <td>{{ $c->created_at->format('d/m/Y') }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center py-4 text-gray-500">Belum ada pelanggan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $customers->links() }}</div>
@endsection