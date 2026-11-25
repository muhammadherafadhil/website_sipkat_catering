<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, HomeController, MenuController, OrderController, PaymentController};
use App\Http\Controllers\Admin\{
    DashboardController, CategoryController, MenuAdminController,
    OrderAdminController, PaymentAdminController, CustomerController, ReportController
};

// ============ PUBLIC ============
Route::get('/',          [HomeController::class, 'index'])->name('home');
Route::get('/menu',      [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{menu}',[MenuController::class, 'show'])->name('menu.show');

// ============ AUTH ============
Route::middleware('guest')->group(function () {
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ============ CUSTOMER ============
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/orders',                  [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create',           [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders',                 [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}',          [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel',  [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/pay',     [PaymentController::class, 'store'])->name('payments.store');
});

// ============ ADMIN ============
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                  [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('menus',      MenuAdminController::class);
    Route::get('customers',       [CustomerController::class, 'index'])->name('customers.index');

    Route::get('orders',                  [OrderAdminController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}',          [OrderAdminController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/confirm', [OrderAdminController::class, 'confirm'])->name('orders.confirm');
    Route::post('orders/{order}/reject',  [OrderAdminController::class, 'reject'])->name('orders.reject');
    Route::post('orders/{order}/status',  [OrderAdminController::class, 'updateStatus'])->name('orders.status');

    Route::get('payments',                        [PaymentAdminController::class, 'index'])->name('payments.index');
    Route::post('payments/{payment}/verify',      [PaymentAdminController::class, 'verify'])->name('payments.verify');
    Route::post('payments/{payment}/reject',      [PaymentAdminController::class, 'reject'])->name('payments.reject');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});