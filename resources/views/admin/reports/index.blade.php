@extends('layouts.app')
@section('title', 'Laporan')
@section('content')
<h1 class="text-2xl font-bold mb-4">Laporan Transaksi</h1>
<form method="GET" class="bg-white p-3 rounded shadow mb-4 flex flex-wrap gap-2">
    <input type="date" name="from" value="{{ $from }}" class="border rounded p-2">
    <input type="date" name="to" value="{{ $to }}" class="border rounded p-2">
    <select name="status" class="border rounded p-2">
        <option value="">Semua Status</option>
        @foreach(\App\Enums\OrderStatus::values() as $s)
            <option @selected(request('status')==$s)>{{ $s }}</option>
        @endforeach
    </select>
    <button class="bg-orange-600 text-white px-4 rounded">Filter</button>
    <button type="button" onclick="window.print()" class="bg-gray-600 text-white px-4 rounded">Cetak</button>
</form>
<div class="bg-white p-4 rounded shadow">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4 text-center">
        <div><p class="text-sm text-gray-500">Total Pesanan</p><p class="font-bold">{{ \App\Models\Order::formatCurrency($totalOrders) }}</p></div>
        <div><p class="text-sm text-gray-500">Terverifikasi</p><p class="font-bold text-green-600">{{ \App\Models\Order::formatCurrency($verifiedPayments) }}</p></div>
        <div><p class="text-sm text-gray-500">Sisa</p><p class="font-bold text-red-600">{{ \App\Models\Order::formatCurrency($sisa) }}</p></div>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left"><tr><th class="p-2">Nomor</th><th>Tanggal</th><th>Pelanggan</th><th>Total</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($orders as $o)
            <tr class="border-b">
                <td class="p-2 font-mono">{{ $o->order_number }}</td>
                <td>{{ $o->created_at->format('d/m/Y') }}</td>
                <td>{{ $o->user->name }}</td>
                <td>{{ $o->formatted_total }}</td>
                <td>{{ $o->order_status }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center py-4 text-gray-500">Tidak ada transaksi di rentang ini.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection