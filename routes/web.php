<?php

use App\Http\Controllers\{
    CategoryController,
    DashboardController
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
        Route::resource('/category', CategoryController::class)->except('edit','create');
    });

    // Role Users
    Route::group([
        'middleware' => 'role:user'
    ], function () {
        // route user
    });
});
