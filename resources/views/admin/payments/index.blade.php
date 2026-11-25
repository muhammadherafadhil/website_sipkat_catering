@extends('layouts.app')
@section('title', 'Pembayaran')
@section('content')
<h1 class="text-2xl font-bold mb-4">Pembayaran Masuk</h1>
<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr><th class="p-2">Tanggal</th><th>Pesanan</th><th>Metode</th><th>Jumlah</th><th>Bukti</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        @forelse($payments as $p)
            <tr class="border-b">
                <td class="p-2">{{ $p->created_at->format('d/m/Y') }}</td>
                <td class="font-mono">{{ $p->order->order_number }}</td>
                <td>{{ $p->payment_method }}</td>
                <td>{{ $p->formatted_amount }}</td>
                <td>
                    @if($p->proof_path)
                        <a href="{{ asset('storage/'.$p->proof_path) }}" target="_blank" class="text-blue-600">Lihat</a>
                    @else — @endif
                </td>
                <td>{{ $p->payment_status }}</td>
                <td class="whitespace-nowrap">
                    @if($p->payment_status === 'Menunggu Verifikasi')
                        <form method="POST" action="{{ route('admin.payments.verify', $p) }}" class="inline">@csrf
                            <button class="text-green-600">Verifikasi</button>
                        </form>
                        <form method="POST" action="{{ route('admin.payments.reject', $p) }}" class="inline ml-2">@csrf
                            <input name="reason" required placeholder="Alasan" class="border rounded px-1 text-xs w-24">
                            <button class="text-red-600">Tolak</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center py-4 text-gray-500">Belum ada pembayaran.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $payments->links() }}</div>
@endsection