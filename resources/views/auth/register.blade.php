@extends('layouts.app')
@section('title', 'Registrasi')
@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Registrasi Pelanggan</h1>
    <form method="POST" action="{{ route('register') }}" class="space-y-3">
        @csrf
        <input name="name" required placeholder="Nama lengkap" value="{{ old('name') }}" class="border rounded p-2 w-full">
        <input name="email" type="email" required placeholder="Email" value="{{ old('email') }}" class="border rounded p-2 w-full">
        <input name="phone" required placeholder="Nomor telepon" value="{{ old('phone') }}" class="border rounded p-2 w-full">
        <input name="password" type="password" required placeholder="Kata sandi (min 8)" class="border rounded p-2 w-full">
        <input name="password_confirmation" type="password" required placeholder="Konfirmasi kata sandi" class="border rounded p-2 w-full">
        <button class="bg-orange-600 text-white px-4 py-2 rounded w-full">Daftar</button>
    </form>
    <p class="text-sm text-center mt-3">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600">Login</a></p>
</div>
@endsection