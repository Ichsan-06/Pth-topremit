<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\RedemptionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', [ApiAuthController::class,'login'])->name('login.api');
    Route::post('/register',[ApiAuthController::class,'register'])->name('register.api');
});

Route::middleware(['cors', 'json.response','auth:api'])->group(function () {
    Route::post('/logout', [ApiAuthController::class,'logout'])->name('logout.api');
    Route::get('/myprofile', [ApiAuthController::class,'myprofile'])->name('myprofile.api');
    Route::post('/verified-account', [ApiAuthController::class,'verifiedaccount'])->name('verifiedaccount.api');
    Route::get('/check-verified-account', [ApiAuthController::class,'checkverifiedaccount'])->name('checkverifiedaccount.api');

    Route::resource('currency', CurrencyController::class);
    Route::resource('voucher', VoucherController::class);

    Route::get('myredemption', [RedemptionController::class,'myredemption']);
    Route::post('redemption', [RedemptionController::class,'store']);

    Route::resource('receipt', ReceiptController::class);
    Route::resource('transaction', TransactionController::class)->only(['index', 'store', 'show']);

    Route::resource('payment', PaymentController::class)->only([ 'store']);
    Route::post('payment-listener', [PaymentController::class,'listener']);

    Route::resource('notification', NotificationController::class)->only(['index']);
});

