<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KwhMeterController;

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

Route::controller(UserController::class)->group(function () {
    Route::get('/login', 'index')->name('loginpage')->middleware('guest');
    Route::get('/register', 'create')->name('registerpage')->middleware('guest');
    Route::post('/login', 'authenticate')->name('login');
    Route::post('/register', 'store')->name('register');
    Route::post('/logout', 'logout')->name('logout');
});

Route::get('/home', [KwhMeterController::class, 'home'])->name('home')->middleware('guest');
Route::get('/monitoring', [KwhMeterController::class, 'monitoring'])->name('monitoring');
Route::get('/', [KwhMeterController::class, 'index'])->name('myadmin')->middleware('auth');
Route::get('/print', [KwhMeterController::class, 'print'])->name('print')->middleware('auth');

Route::get('/testing', function() {
    return view('pages.testing.test');
});
