@extends('layouts.app')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
    @if (isset($product))
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Produk: {{ $product->name }}</h2>
        <form action="{{ route('admin.products.update', $product) }}" method="POST">
            @method('PUT')
    @else
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Produk Baru</h2>
        <form action="{{ route('admin.products.store') }}" method="POST">
    @endif

        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
            <input type="text" name="name" id="name"
                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg p-2 @error('name') border-red-500 @enderror"
                   value="{{ old('name', $product->name ?? '') }}" required maxlength="100">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
            <input type="number" name="price" id="price"
                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg p-2 @error('price') border-red-500 @enderror"
                   value="{{ old('price', $product->price ?? '') }}" required min="1">
            @error('price')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
            <input type="number" name="stock" id="stock"
                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg p-2 @error('stock') border-red-500 @enderror"
                   value="{{ old('stock', $product->stock ?? '') }}" required min="0">
            @error('stock')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900 font-medium py-2 px-4 rounded-lg transition duration-150">
                Kembali
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 shadow-md">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection