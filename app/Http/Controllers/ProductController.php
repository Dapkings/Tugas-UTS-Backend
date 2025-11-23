<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar semua produk (Public).
     */
    public function index()
    {
        // Tampilkan semua produk
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Tampilkan form untuk membuat produk baru (Public/Admin).
     */
    public function create()
    {
        // Menampilkan form create/edit (tanpa data produk)
        return view('products.create');
    }

    /**
     * Simpan produk baru ke database (Admin Protected).
     */
    public function store(Request $request)
    {
        // Validasi data menggunakan Validator::make()
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100', // Wajib, maks 100 karakter
            'price' => 'required|numeric|gt:0', // Wajib, lebih besar dari 0
            'stock' => 'required|integer|min:0', // Wajib, angka bulat >= 0
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

        // Jika validasi gagal, kembalikan ke form dengan pesan error
        if ($validator->fails()) {
            Session::flash('error', 'Validasi gagal. Mohon periksa kembali input Anda.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Simpan data ke tabel products menggunakan Eloquent ORM
            Product::create($request->all());

            Session::flash('success', 'Produk berhasil ditambahkan!');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menyimpan produk: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Tampilkan form untuk mengedit produk yang ada (Admin Protected).
     */
    public function edit(Product $product)
    {
        // Tampilkan form create/edit dengan data produk
        return view('products.create', compact('product'));
    }

    /**
     * Perbarui data produk di database (Admin Protected).
     */
    public function update(Request $request, Product $product)
    {
        // Validasi data menggunakan Validator::make()
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

        // Jika validasi gagal
        if ($validator->fails()) {
            Session::flash('error', 'Validasi gagal saat update. Mohon periksa kembali input Anda.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Update data menggunakan Eloquent ORM
            $product->update($request->all());

            Session::flash('success', 'Produk berhasil diperbarui!');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal memperbarui produk: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Hapus produk dari database (Admin Protected).
     */
    public function destroy(Product $product)
    {
        try {
            // Hapus data menggunakan Eloquent ORM
            $product->delete();

            Session::flash('success', 'Produk berhasil dihapus!');
            return redirect()->route('admin.products.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menghapus produk: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}