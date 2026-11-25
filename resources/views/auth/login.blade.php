@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Login</h1>
    <form method="POST" action="{{ route('login') }}" class="space-y-3">
        @csrf
        <input name="email" type="email" required placeholder="Email" value="{{ old('email') }}" class="border rounded p-2 w-full">
        <input name="password" type="password" required placeholder="Kata sandi" class="border rounded p-2 w-full">
        <button class="bg-orange-600 text-white px-4 py-2 rounded w-full">Masuk</button>
    </form>
    <p class="text-sm text-center mt-3">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600">Daftar</a></p>
</div>
@endsection