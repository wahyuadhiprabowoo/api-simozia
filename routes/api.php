<?php

use App\Http\Controllers\BalitaController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\PuskesmasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();});
// login
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgotpassword', [AuthController::class, 'forgotPassword']);

// autentifikasi api 
Route::middleware('auth:api')->group(function () {

// userApi Login
Route::get('/user', [AuthController::class, 'userApi']);
Route::patch('/user', [AuthController::class, 'update']);
//all data
Route::get('/all', [PuskesmasController::class, 'all']); 
// puskesmas
Route::get('/puskesmas', [PuskesmasController::class, 'indexApi']); //all puskesmas
Route::get('/puskesmas/{id}', [PuskesmasController::class, 'showApi']); //detail puskesmas
Route::post('/puskesmas', [PuskesmasController::class, 'store']);
Route::get('/puskespos', [PuskesmasController::class, 'showApiPuskespos']); //puskesmas dan posyandu

// posyandu
Route::get('/puskesmas/{id_puskesmas}/posyandu', [PosyanduController::class, 'indexApi']);
Route::get('/puskesmas/{id_puskesmas}/posyandu/{id}', [PosyanduController::class, 'showApi']);
// balita dari posyandu
Route::get('/posyandu/{posyanduId}/balitas', [BalitaController::class, 'indexFromPosyandu']);

// balita
Route::get('/puskesmas/{id_puskesmas}/posyandu/{id_posyandu}/balita', [BalitaController::class, 'indexApi']);
Route::get('/puskesmas/{id_puskesmas}/posyandu/{id_posyandu}/balita/{id_balita}', [BalitaController::class, 'showApi']);
Route::post('/puskesmas/{id_puskesmas}/posyandu/{id_posyandu}/balita', [BalitaController::class, 'storeApi']);
Route::patch('/puskesmas/{id_puskesmas}/posyandu/{id_posyandu}/balita/{id_balita}', [BalitaController::class, 'updateApi']);
Route::delete('/puskesmas/{id_puskesmas}/posyandu/{id_posyandu}/balita/{id_balita}', [BalitaController::class, 'destroyApi']);
// filtering
//single filter
Route::get('/puskesmas/{id_puskesmas}/posyandu/{id_posyandu}/balita/filter-panjang/{klasifikasi_panjang_badan}', [BalitaController::class, 'filterByKlasifikasiPanjangBadan']); //panjang badan
Route::get('/puskesmas/{id_puskesmas}/posyandu/{id_posyandu}/balita/filter-berat/{klasifikasi_berat_badan}', [BalitaController::class, 'filterByKlasifikasiBeratBadan']); //berat badan
Route::get('/puskesmas/{id_puskesmas}/posyandu/{id_posyandu}/balita/filter-detak/{klasifikasi_detak_jantung}', [BalitaController::class, 'filterByKlasifikasiDetakJantung']); //detak jantung
Route::get('/puskesmas/{id_puskesmas}/posyandu/{id_posyandu}/balita/filter-create-at', [BalitaController::class, 'filterByKlasifikasiCreatedAt']); //create-at

Route::get('/balitas', [BalitaController::class, 'filteringQuery']); 
// loggiut
Route::post('/logout', [AuthController::class, 'logout']);
});
// Route::get('/balitas', [BalitaController::class, 'index']); 
