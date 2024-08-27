<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PadiAmatanController;
use App\Http\Controllers\PadiValidasiController;
use App\Models\User;
use Carbon\Carbon;

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
    return redirect('login');
});

Route::get('/home', function () {
    return redirect('dashboard');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware("guest");
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/padi_kondef', function () {
    return view('padi.kondef');
})->middleware('auth')->name('padi_kondef');

// Route::get('/padi_unggah', function () {
//     return view('padi.unggah');
// })->middleware('auth')->name('padi_unggah');
Route::get('/padi_unggah', [PadiAmatanController::class, 'showUploadForm'])->middleware('auth')->name('padi_unggah');
// Route::post('/padiamatan/upload', [PadiAmatanController::class, 'uploadExcel'])->name('padiamatan.upload');
Route::post('/padiamatan/upload', [PadiAmatanController::class, 'import'])->name('padiamatan.upload');

// Route::get('/padi_riwayat', function () {
//     return view('padi.riwayat');
// })->middleware('auth')->name('padi_riwayat');

Route::get('/padi_riwayat', [PadiAmatanController::class, 'riwayat'])->middleware('auth')->name('padi_riwayat');
Route::get('/padi_detail/{id}', [PadiAmatanController::class, 'showDetail']);

Route::get('/padi_validasi', [PadiValidasiController::class, 'showValidasi'])->middleware('auth')->name('padi_validasi');
Route::post('/padi_validasi', [PadiValidasiController::class, 'showValidasi'])->middleware('auth')->name('padi_validasi_post');

Route::get('/padi_panduan', function () {
    return view('padi.panduan');
})->middleware('auth')->name('padi_panduan');

Route::get('/test-proses', [PadiValidasiController::class, 'showTestPage']);
Route::post('/test-proses', [PadiValidasiController::class, 'proses'])->name('test.proses');