<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;

// Halaman Beranda (Home)
Route::get('/', [EventController::class, 'index'])->name('welcome');

// Halaman Detail Event
Route::get('/event-detail', [EventController::class, 'show'])->name('event-detail');

// Halaman Checkout
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');

// Halaman Ticket (Setelah Bayar)
Route::get('/ticket', function () {
    return view('ticket');
})->name('ticket');


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    // Halaman Dashboard Admin (URL: /admin)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Halaman Kelola Event Admin (URL: /admin/events)
    Route::resource('events', AdminEventController::class)->except(['show']);

    // Halaman Kelola Kategori Admin (URL: /admin/categories)
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Halaman Kelola Partner Admin (URL: /admin/partners)
    Route::get('/partners', [AdminPartnerController::class, 'index'])->name('partners.index');
    Route::get('/partners/create', [AdminPartnerController::class, 'create'])->name('partners.create');
    Route::post('/partners', [AdminPartnerController::class, 'store'])->name('partners.store');
    Route::get('/partners/{partner}/edit', [AdminPartnerController::class, 'edit'])->name('partners.edit');
    Route::put('/partners/{partner}', [AdminPartnerController::class, 'update'])->name('partners.update');
    Route::delete('/partners/{partner}', [AdminPartnerController::class, 'destroy'])->name('partners.destroy');

    // Halaman Laporan Transaksi Admin (URL: /admin/transactions)
    Route::resource('transactions', AdminTransactionController::class)->except(['show']);
});
