<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda.
|
*/

// Rute untuk Halaman Utama (Bisa disesuaikan)
Route::get('/', function () {
    return view('welcome');
});

// =========================================================
// Bagian 1: Rute Publik yang Diminta (SCPMK.04, SCPMK.02)
// =========================================================

// a) Rute GET /products untuk menampilkan daftar produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// =========================================================
// Bagian 2: Rute Admin (CRUD) yang Dilindungi Middleware 'auth' (SCPMK.04)
// =========================================================

Route::middleware(['auth'])->group(function () {
    // Gunakan Route::resource untuk CRUD di bawah prefix /admin
    // Ini melindungi halaman admin (/admin/products) dan semua operasi CRUD
    Route::resource('admin/products', ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);

    // PERBAIKAN ERROR 'profile.edit':
    // Arahkan /dashboard langsung ke halaman admin produk setelah login.
    Route::get('/dashboard', function () {
        return redirect()->route('admin.products.index'); // Langsung diarahkan ke daftar produk admin
    })->name('dashboard'); // Name 'dashboard' tetap dipertahankan
});

// Impor rute autentikasi dari Breeze
require __DIR__.'/auth.php';