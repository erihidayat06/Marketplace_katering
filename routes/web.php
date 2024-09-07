<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductMakananController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;

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

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', [ProfileController::class, 'index']);
Route::put('/dashboard/profile/update', [ProfileController::class, 'update']);
Route::get('/merchant/{merchant:slug}', [ProfileController::class, 'merchant']);

Route::get('/daftar-merchant/create', [ProfileController::class, 'create']);
Route::post('/daftar-merchant', [ProfileController::class, 'store']);

Route::resource('/dashboard/product', ProductMakananController::class);

Route::post('/transaction/store', [TransactionController::class, 'store']);

Route::get('/login-customer', []);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
