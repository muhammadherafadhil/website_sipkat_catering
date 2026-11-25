@extends('layouts.app')
@section('title', 'Buat Pesanan')
@section('content')
<h1 class="text-2xl font-bold mb-4">Buat Pesanan</h1>

<form method="POST" action="{{ route('orders.store') }}" id="orderForm">
    @csrf

    <div class="bg-white p-4 rounded shadow mb-4">
        <h2 class="font-semibold mb-2">Pilih Menu</h2>
        @foreach($menus as $menu)
            <div class="flex items-center gap-3 py-2 border-b">
                <label class="flex-1">
                    <input type="checkbox" onchange="toggleRow({{ $menu->id }})" id="chk_{{ $menu->id }}">
                    {{ $menu->name }} — {{ $menu->formatted_price }}
                </label>
                <input type="hidden" name="items[{{ $menu->id }}][menu_id]" value="{{ $menu->id }}" disabled id="mid_{{ $menu->id }}">
                <input type="number" min="1" value="1" name="items[{{ $menu->id }}][quantity]" 
                       class="w-20 border rounded px-2" disabled id="qty_{{ $menu->id }}">
            </div>
        @endforeach
    </div>

    <div class="bg-white p-4 rounded shadow mb-4 grid grid-cols-1 md:grid-cols-2 gap-3">
        <input name="recipient_name" required placeholder="Nama penerima" class="border rounded p-2" value="{{ old('recipient_name', auth()->user()->name) }}">
        <input name="recipient_phone" required placeholder="Telepon penerima" class="border rounded p-2" value="{{ old('recipient_phone', auth()->user()->phone) }}">
        <textarea name="delivery_address" required placeholder="Alamat pengiriman" class="border rounded p-2 md:col-span-2"></textarea>
        <input type="datetime-local" name="requested_delivery_at" required class="border rounded p-2">
        <input name="notes" placeholder="Catatan (opsional)" class="border rounded p-2">
    </div>

    <button class="bg-orange-600 text-white px-6 py-2 rounded">Kirim Pesanan</button>
</form>

<script>
function toggleRow(id) {
    const chk = document.getElementById('chk_' + id);
    const mid = document.getElementById('mid_' + id);
    const qty = document.getElementById('qty_' + id);
    mid.disabled = qty.disabled = !chk.checked;
}
</script>
@endsection