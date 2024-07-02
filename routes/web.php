<?php

use App\Http\Controllers\PaymentController;
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
    return view('welcome');
});

Route::post('/handle-payment-confirmation', [PaymentController::class, 'processPayment']);

Route::get('/payment', [PaymentController::class, 'index']);
Route::post('/payment/process', [PaymentController::class, 'processPayment']);

