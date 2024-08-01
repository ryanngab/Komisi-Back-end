<?php

use App\Http\Controllers\CommissionController;
use Illuminate\Http\Request;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PenjualanController;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/daftar-marketing', [MarketingController::class, 'index']);
Route::post('/create-marketing', [MarketingController::class, 'store']);

Route::get('/daftar-penjualan', [ PenjualanController::class, 'index']);
Route::post('/create-penjualan', [PenjualanController::class, 'store']);


Route::get('/daftar-pembayaran', [PembayaranController::class, 'index']);

Route::get('/komisi', [CommissionController::class, 'calculateCommissions']);
Route::post('/pembayaran', [PembayaranController::class, 'store']);


