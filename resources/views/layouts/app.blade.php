<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Produk</title>
    <!-- Asumsi menggunakan Tailwind CSS (sudah ada jika menggunakan Breeze) -->
    <!-- Ini akan memuat Tailwind CSS dari CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen">
        <!-- Header Navigasi dibuat di sini, BUKAN melalui include('layouts.navigation') -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Aplikasi Produk</h1>
                <nav class="space-x-4">
                    <!-- Navigasi Publik -->
                    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900">Daftar Produk (Publik)</a>
                    @auth
                        <!-- Navigasi Admin (Jika sudah login) -->
                        <a href="{{ route('admin.products.index') }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Admin Produk</a>
                        <!-- Tombol Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-900">Logout</button>
                        </form>
                    @else
                        <!-- Navigasi Autentikasi (Jika belum login) -->
                        <a href="{{ route('login') }}" class="text-green-600 hover:text-green-900">Login</a>
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-900">Register</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Tampilkan pesan sukses/error dari session -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>