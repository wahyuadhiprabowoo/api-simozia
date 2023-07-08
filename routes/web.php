<?php

use App\Http\Controllers\FilterController;
use App\Http\Controllers\FilterPosyanduController;
use App\Http\Controllers\PuskesmasController;
use App\Models\Puskesmas;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});
// balita
Route::get('/filter',[FilterController::class, 'index']);
Route::get('/getposyandu',[FilterController::class, 'getPosyandu']);
Route::get('/filter/{puskesmasId}/getPosyandu', [PosyanduController::class, 'getPosyandu'])->name('posyandu.getPosyandu');
Route::get('/filter/getBalitaByPosyandu', [FilterController::class, 'getBalitaByPosyandu'])->name('balita.getBalitaByPosyandu');
Route::get('/filter/getPosyanduByPuskesmas', [PosyanduController::class, 'getPosyanduByPuskesmas'])->name('posyandu.getPosyanduByPuskesmas');

// posyandu
Route::get('/posyandu', [FilterPosyanduController::class, 'index']);
Route::get('/posyandu/getPosyanduByPuskesmas', [FilterPosyanduController::class, 'getPosyanduByPuskesmas'])->name('posyandu.getPosyanduByPuskesmasOnly');
Route::post('/posyandu/store', [FilterPosyanduController::class, 'store'])->name('posyandu.store');
Route::get('/posyandu/get', [FilterPosyanduController::class, 'get'])->name('posyandu.get');
Route::delete('/posyandu/delete', [FilterPosyanduController::class, 'delete'])->name('posyandu.delete');
Route::patch('/posyandu/update', 'FilterPosyanduController@update')->name('posyandu.update');
