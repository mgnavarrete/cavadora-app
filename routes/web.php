<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShiftController;
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

// AUTHENTICATION //
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('index');
    }
    return view('pages.inicio');
})->name('inicio');  // Redirige a 'index' si el usuario está autenticado, de lo contrario muestra 'inicio'

// // LOGIN //
Route::post('/registrar', [LoginController::class, 'registrar'])->name('registrar');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('index', [IndexController::class, 'index'])->name('index');
    Route::get('calendar', [IndexController::class, 'calendar'])->name('calendar');


    # PAYMENTS
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments/{id}/pdf', [PaymentController::class, 'generatePDF'])->name('payments.pdf');
    Route::put('/payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.updateStatus');
    Route::put('/payments/{payment}/update', [PaymentController::class, 'updatePaymentAndOrder'])->name('payments.updatePaymentAndOrder');

    # ORDERS
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    # SHIFTS
    Route::post('/shifts', [ShiftController::class, 'store'])->name('shifts.store');
    Route::put('/shifts/{shift}/status', [ShiftController::class, 'updateStatus'])->name('shifts.updateStatus');
    Route::delete('/shifts/{shift}', [ShiftController::class, 'destroy'])->name('shifts.destroy');
});
