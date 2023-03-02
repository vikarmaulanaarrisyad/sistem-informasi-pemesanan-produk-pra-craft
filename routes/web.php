<?php

use App\Http\Controllers\{
    CategoryController,
    DashboardController,
    OrderController,
    ProductController,
    PelangganController,
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

Route::get('/', function () {
    return view('auth.login');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::group([
    'middleware' => ['auth', 'role:admin,user']
], function () {
    // Halaman Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // Role Admin
    Route::group([
        'middleware' => 'role:admin'
    ], function () {
        Route::resource('/category', CategoryController::class)->except('edit', 'create');
        Route::resource('/product', ProductController::class)->except('edit', 'create');
        Route::resource('/pelanggan', PelangganController::class)->except('edit', 'create');
        Route::get('/orders/{id}/detail', [OrderController::class, 'detail'])->name('orders.detail');
        Route::resource('/orders', OrderController::class)->except('edit', 'create');
        Route::put('/orders/{id}/update_status', [OrderController::class, 'updateStatus'])->name('orders.update_status');
    });

    // Role Users
    Route::group([
        'middleware' => 'role:user'
    ], function () {
        // route user
    });
});
