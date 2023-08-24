<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\KwhMeterController;
use App\Http\Controllers\TransactionController;

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

Route::controller(KwhMeterController::class)->group(function () {
    Route::get('/usermtr', 'list')->name('userkwhlist');
    Route::post('/usermtr', 'addList')->name('addkwhlist');
    Route::delete('/usermtr/{kwhMeter}', 'destroy')->name('deletekwhlist');
    Route::put('/kwh/{kwhMeter}/generate', 'generate')->name('genToken');

    Route::get('/kwh/{kwhMeter}', 'show')->name('getMeter');
    Route::post('/kwh', 'store')->name('addKwh');
    Route::put('/kwh/{kwhMeter}', 'update');
});

Route::controller(TransactionController::class)->group(function () {
    Route::get('/trx/{kwhMeter}', 'show')->name('trxlist');
    Route::post('/trx', 'store')->name('buyToken');
    Route::put('/trx/{transaction}', 'update');
});

Route::controller(HistoryController::class)->group(function () {
    Route::get('/his/{kwhMeter}', 'show')->name('histoken');
    Route::post('/his', 'store');
});

Route::get('/tes', function() {
    return response()->json([
        'success' => true,
        'date' => now()->toDateString(),
        'time' => now()->toTimeString(),
        'timestamp' => now()->getTimestamp()
    ]);
});
