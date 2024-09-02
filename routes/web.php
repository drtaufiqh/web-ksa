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

// default page
Route::get('/', function () {
    return redirect('login');
});
Route::get('/home', function () {
    return redirect('padi_dashboard');
})->middleware('auth');
Route::get('/dashboard', function () {
    return view('padi.dashboard');
})->middleware('auth');

// login logout
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware("guest");
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// padi

// padi_dashboard
Route::get('/padi_dashboard', function () {
    return view('padi.dashboard');
})->middleware('auth')->name('padi_dashboard');

// padi_kondef
Route::get('/padi_kondef', function () {
    return view('padi.kondef');
})->middleware('auth')->name('padi_kondef');

// padi_unggah
Route::get('/padi_unggah', [PadiAmatanController::class, 'showUploadForm'])->middleware('auth')->name('padi_unggah');
Route::post('/padiamatan/upload', [PadiAmatanController::class, 'import'])->name('padiamatan.upload');

// padi_riwayat
Route::get('/padi_riwayat', [PadiAmatanController::class, 'riwayat'])->middleware('auth')->name('padi_riwayat');
Route::get('/padi_detail/{id}', [PadiAmatanController::class, 'showDetail']);

// padi_validasi
Route::get('/padi_validasi', [PadiValidasiController::class, 'showValidasi'])->middleware('auth')->name('padi_validasi');
Route::post('/padi_validasi', [PadiValidasiController::class, 'showValidasi'])->middleware('auth')->name('padi_validasi_post');
Route::get('/get-filtered-data', [PadiValidasiController::class, 'getFilteredData']);

// padi_panduan
Route::get('/padi_panduan', function () {
    return view('padi.panduan');
})->middleware('auth')->name('padi_panduan');

// testing only
Route::get('/test-proses', [PadiAmatanController::class, 'testProses'])->name('test.proses');
Route::post('/test-proses', [PadiAmatanController::class, 'runProses'])->name('run.proses');

Route::get('/test-peta', [PadiAmatanController::class, 'testPeta']);
Route::post('/get-data-peta', [PadiAmatanController::class, 'getDataPeta'])->name('get.data.peta');

Route::get('/test-progres', [PadiAmatanController::class, 'testProgres']);
Route::post('/get-data-progres', [PadiAmatanController::class, 'getDataProgres'])->name('get.data.progres');

Route::get('/test-terakhir', [PadiAmatanController::class, 'testTerakhir']);
Route::get('/get-data-terakhir', [PadiAmatanController::class, 'getDataTerakhir']);
Route::post('/get-data-terakhir', [PadiAmatanController::class, 'getDataTerakhir'])->name('get.data.terakhir');

Route::get('/test-berjalan', [PadiAmatanController::class, 'testBerjalan']);
Route::get('/get-data-berjalan', [PadiAmatanController::class, 'getDataBerjalan']);
Route::post('/get-data-berjalan', [PadiAmatanController::class, 'getDataBerjalan'])->name('get.data.berjalan');

// padi

// jagung_dashboard
Route::get('/jagung_dashboard', function () {
    return view('jagung.dashboard');
})->middleware('auth')->name('jagung_dashboard');

// jagung_kondef
Route::get('/jagung_kondef', function () {
    return view('jagung.kondef');
})->middleware('auth')->name('jagung_kondef');

// jagung_unggah
Route::get('/jagung_unggah', function () {
    return view('jagung.unggah');
})->middleware('auth')->name('jagung_unggah');

// jagung_riwayat
Route::get('/jagung_riwayat', function () {
    return view('jagung.riwayat');
})->middleware('auth')->name('jagung_riwayat');

// jagung_validasi
Route::get('/jagung_validasi', function () {
    return view('jagung.validasi');
})->middleware('auth')->name('jagung_validasi');

// jagung_panduan
Route::get('/jagung_panduan', function () {
    return view('jagung.panduan');
})->middleware('auth')->name('jagung_panduan');