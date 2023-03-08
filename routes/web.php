<?php

use App\Http\Controllers\{
    CategoryController,
    DashboardController,
    OrderController,
    ProductController,
    PelangganController,
    ReportController,
};
use App\Http\Controllers\Front\{
    FrontController,
    FrontOrderController,
    FrontProductController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FrontController::class, 'index'])->name('homepage');
Route::resource('/produk', FrontProductController::class);



Route::group([
    'middleware' => ['auth', 'role:admin,user']
], function () {
    // Halaman Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route Product
    Route::get('/product/data', [ProductController::class, 'getDataProduct'])->name('data.product');
    Route::resource('/product', ProductController::class)->except('edit', 'create');

    Route::controller(OrderController::class)->group(function () {
        // Route Order / Pesanan
        Route::get('/orders/data', [OrderController::class, 'getDataOrder'])->name('data.order');
        Route::get('/orders/{id}/detail', [OrderController::class, 'detail'])->name('orders.detail');
        Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('/orders/{id}/print_invoice', [OrderController::class, 'printInvoice'])->name('orders.print_invoice');
        Route::put('/orders/{id}/update_status', [OrderController::class, 'updateStatus'])->name('orders.update_status');
    });

    Route::resource('/orders', OrderController::class)->except('edit', 'create');

    Route::controller(FrontOrderController::class)->group(function () {
        Route::get('/orders/{order}/show_cart', [FrontOrderController::class, 'showCart'])->name('orders.show_cart');
        Route::get('/orders/{order}/products/{product}/delete', [FrontOrderController::class, 'removeFromCart'])->name('orders.remove_cart');
        Route::post('/orders/{slug}/add_cart', [FrontOrderController::class, 'addToCart'])->name('orders.add_cart');
        Route::get('/orders/{id}/update_cart', [FrontOrderController::class, 'updateCart'])->name('orders.update_cart');
    });



    // Role Admin
    Route::group([
        'middleware' => 'role:admin'
    ], function () {
        // Route Category
        Route::get('/categories/data', [CategoryController::class, 'getDataCategory'])->name('data.category');
        Route::resource('/category', CategoryController::class)->except('edit', 'create');

        // Route Product
        Route::get('/categories/search', [ProductController::class, 'getCategoryProduct'])->name('search.category');

        // Route Product
        Route::get('/pelanggan/data', [PelangganController::class, 'getDataPelanggan'])->name('data.pelanggan');
        Route::resource('/pelanggan', PelangganController::class)->except('edit', 'create');

        Route::controller(ReportController::class)->group(function () {
            // Report : Laporan
            Route::get('/report', [ReportController::class, 'index'])->name('report.index');
            Route::get('/report/data/{start}/{end}', [ReportController::class, 'data'])->name('report.data');
            Route::get('/report/pdf/{start}/{end}', [ReportController::class, 'exportPDF'])->name('report.export_pdf');
        });
    });

    // Role Users
    Route::group([
        'middleware' => 'role:user'
    ], function () {
        // Route::resource('/order', FrontOrderController::class);
    });
});
