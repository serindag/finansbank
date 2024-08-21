<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SingleBankThreeDSecurePaymentController;
use Illuminate\Support\Facades\Route;

Route::match(['POST'], '/single-bank/payment/3d/form', [\App\Http\Controllers\SingleBankThreeDSecurePaymentController::class, 'form'])->name("pay.form");
Route::match(['GET', 'POST'], '/single-bank/payment/3d/response', [\App\Http\Controllers\SingleBankThreeDSecurePaymentController::class, 'response']);

Route::get('/', [SingleBankThreeDSecurePaymentController::class, "index"])->name("pay.index");


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard',[CartController::class,'index'])->name('dashboard');

});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
