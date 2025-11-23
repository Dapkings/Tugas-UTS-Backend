<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
   
    public function index()
    {
        // Tampilkan semua produk
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100', 
            'price' => 'required|numeric|gt:0', 
            'stock' => 'required|integer|min:0',
        ], [
            // Pesan kesalahan kustom (dalam Bahasa Indonesia)
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk maksimal 100 karakter.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.gt' => 'Harga harus lebih besar dari 0.',
            'stock.required' => 'Stok produk wajib diisi.',
            'stock.integer' => 'Stok harus berupa bilangan bulat.',
            'stock.min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Validasi gagal. Mohon periksa kembali input Anda.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Product::create($request->all());

            Session::flash('success', 'Produk berhasil ditambahkan!');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menyimpan produk: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit(Product $product)
    {
        // Tampilkan form create/edit dengan data produk
        return view('products.create', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|gt:0',
            'stock' => 'required|integer|min:0',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk maksimal 100 karakter.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.gt' => 'Harga harus lebih besar dari 0.',
            'stock.required' => 'Stok produk wajib diisi.',
            'stock.integer' => 'Stok harus berupa bilangan bulat.',
            'stock.min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Validasi gagal saat update. Mohon periksa kembali input Anda.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $product->update($request->all());

            Session::flash('success', 'Produk berhasil diperbarui!');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal memperbarui produk: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

            Session::flash('success', 'Produk berhasil dihapus!');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menghapus produk: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}