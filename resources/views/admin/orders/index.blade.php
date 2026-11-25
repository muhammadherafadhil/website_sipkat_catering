@extends('layouts.app')
@section('title', 'Kelola Pesanan')
@section('content')
<h1 class="text-2xl font-bold mb-4">Pesanan</h1>
<form method="GET" class="bg-white p-3 rounded shadow mb-4 flex flex-wrap gap-2">
    <input type="date" name="from" value="{{ request('from') }}" class="border rounded p-2">
    <input type="date" name="to" value="{{ request('to') }}" class="border rounded p-2">
    <select name="status" class="border rounded p-2">
        <option value="">Semua Status</option>
        @foreach($statuses as $s)<option @selected(request('status')==$s)>{{ $s }}</option>@endforeach
    </select>
    <button class="bg-orange-600 text-white px-4 rounded">Filter</button>
</form>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left"><tr><th class="p-2">Nomor</th><th>Tanggal</th><th>Pelanggan</th><th>Total</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse($orders as $o)
            <tr class="border-b">
                <td class="p-2 font-mono">{{ $o->order_number }}</td>
                <td>{{ $o->created_at->format('d/m/Y') }}</td>
                <td>{{ $o->user->name }}</td>
                <td>{{ $o->formatted_total }}</td>
                <td>{{ $o->order_status }}</td>
                <td><a href="{{ route('admin.orders.show', $o) }}" class="text-blue-600">Detail</a></td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center py-4 text-gray-500">Belum ada pesanan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection