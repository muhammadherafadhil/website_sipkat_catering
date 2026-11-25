<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPKAT')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
<nav class="bg-white shadow">
    <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ route('home') }}" class="font-bold text-xl text-orange-600">🍱 SIPKAT</a>
        <div class="flex gap-4 items-center">
            <a href="{{ route('menu.index') }}">Katalog</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600">Dashboard Admin</a>
                @else
                    <a href="{{ route('orders.index') }}">Pesanan Saya</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="text-red-600">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}" class="bg-orange-600 text-white px-3 py-1 rounded">Daftar</a>
            @endauth
        </div>
    </div>
</nav>
<main class="max-w-6xl mx-auto px-4 py-6">
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul>@foreach($errors->all() as $e) <li>• {{ $e }}</li> @endforeach</ul>
        </div>
    @endif
    @yield('content')
</main>
</body>
</html>