<?php

use App\Http\Controllers\PetaniController;
use App\Http\Controllers\UbinanController;
use App\Models\PadiAmatan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PadiAmatanController;
use App\Http\Controllers\PadiValidasiController;
use App\Http\Controllers\JagungAmatanController;
use App\Http\Controllers\JagungValidasiController;
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
Route::get('/dashboard', [PadiAmatanController::class, 'showDashboard'])->middleware('auth');

// login logout
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware("guest");
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// padi

// padi_dashboard
Route::get('/padi_dashboard', [PadiAmatanController::class, 'showDashboard'])->middleware('auth')->name('padi_dashboard');

// padi_kondef
Route::get('/padi_kondef', function () {
    return view('padi.kondef');
})->middleware('auth')->name('padi_kondef');

// padi_unggah
Route::get('/padi_unggah', [PadiAmatanController::class, 'showUploadForm'])->middleware('auth')->name('padi_unggah');
Route::post('/padiamatan/upload', [PadiAmatanController::class, 'import'])->name('padiamatan.upload');

// padi_riwayat
Route::get('/padi_riwayat', [PadiAmatanController::class, 'riwayat'])->middleware('auth')->name('padi_riwayat');
Route::get('/padi_detail/{id}/{tahun}/{bulan}', [PadiAmatanController::class, 'showDetail']);

// padi_validasi
Route::get('/padi_validasi', [PadiValidasiController::class, 'showValidasi'])->middleware('auth')->name('padi_validasi');
Route::post('/padi_validasi', [PadiValidasiController::class, 'showValidasi'])->middleware('auth')->name('padi_validasi_post');
Route::get('/padi-get-filtered-data', [PadiValidasiController::class, 'getFilteredData'])->middleware('auth');

// padi_panduan
Route::get('/padi_panduan', function () {
    return view('padi.panduan');
})->middleware('auth')->name('padi_panduan');


Route::get('/test-peta', [PadiAmatanController::class, 'testPeta']);
Route::get('/padi-get-data-peta', [PadiAmatanController::class, 'getDataPeta']);
Route::post('/padi-get-data-peta', [PadiAmatanController::class, 'getDataPeta'])->name('padi.get.data.peta');

Route::get('/test-progres', [PadiAmatanController::class, 'testProgres']);
Route::get('/padi-get-data-progres', [PadiAmatanController::class, 'getDataProgres']);
Route::post('/padi-get-data-progres', [PadiAmatanController::class, 'getDataProgres'])->name('padi.get.data.progres');

Route::get('/test-terakhir', [PadiAmatanController::class, 'testTerakhir']);
Route::get('/padi-get-data-terakhir', [PadiAmatanController::class, 'getDataTerakhir']);
Route::post('/padi-get-data-terakhir', [PadiAmatanController::class, 'getDataTerakhir'])->name('padi.get.data.terakhir');

Route::get('/test-berjalan', [PadiAmatanController::class, 'testBerjalan']);
Route::get('/padi-get-data-berjalan', [PadiAmatanController::class, 'getDataBerjalan']);
Route::post('/padi-get-data-berjalan', [PadiAmatanController::class, 'getDataBerjalan'])->name('padi.get.data.berjalan');

// testing only
Route::get('/test-proses', [PadiAmatanController::class, 'testProses'])->name('test.proses');
Route::post('/test-proses', [PadiAmatanController::class, 'runProses'])->name('run.proses');

// jagung

// jagung_dashboard
Route::get('/jagung_dashboard', [JagungAmatanController::class, 'showDashboard'])->middleware('auth')->name('jagung_dashboard');

// jagung_kondef
Route::get('/jagung_kondef', function () {
    return view('jagung.kondef');
})->middleware('auth')->name('jagung_kondef');

// jagung_unggah
Route::get('/jagung_unggah', [JagungAmatanController::class, 'showUploadForm'])->middleware('auth')->name('jagung_unggah');
Route::post('/jagungamatan/upload', [JagungAmatanController::class, 'import'])->name('jagungamatan.upload');

// jagung_riwayat
Route::get('/jagung_riwayat', [JagungAmatanController::class, 'riwayat'])->middleware('auth')->name('jagung_riwayat');
Route::get('/jagung_detail/{id}/{tahun}/{bulan}', [JagungAmatanController::class, 'showDetail']);

// jagung_validasi
Route::get('/jagung_validasi', [JagungValidasiController::class, 'showValidasi'])->middleware('auth')->name('jagung_validasi');
Route::post('/jagung_validasi', [JagungValidasiController::class, 'showValidasi'])->middleware('auth')->name('jagung_validasi_post');
Route::get('/get-filtered-data', [JagungValidasiController::class, 'getFilteredData'])->middleware('auth');

// jagung_panduan
Route::get('/jagung_panduan', function () {
    return view('jagung.panduan');
})->middleware('auth')->name('jagung_panduan');

Route::get('/jagung-test-peta', [JagungAmatanController::class, 'testPeta']);
Route::post('/jagung-get-data-peta', [JagungAmatanController::class, 'getDataPeta'])->name('jagung.get.data.peta');

Route::get('/jagung-test-progres', [JagungAmatanController::class, 'testProgres']);
Route::post('/jagung-get-data-progres', [JagungAmatanController::class, 'getDataProgres'])->name('jagung.get.data.progres');

Route::get('/jagung-test-terakhir', [JagungAmatanController::class, 'testTerakhir']);
Route::get('/jagung-get-data-terakhir', [JagungAmatanController::class, 'getDataTerakhir']);
Route::post('/jagung-get-data-terakhir', [JagungAmatanController::class, 'getDataTerakhir'])->name('jagung.get.data.terakhir');

Route::get('/jagung-test-berjalan', [JagungAmatanController::class, 'testBerjalan']);
Route::get('/jagung-get-data-berjalan', [JagungAmatanController::class, 'getDataBerjalan']);
Route::post('/jagung-get-data-berjalan', [JagungAmatanController::class, 'getDataBerjalan'])->name('jagung.get.data.berjalan');

// ubinan

Route::get('/ubinan-lacak', [UbinanController::class, 'showLacak'])->name('ubinan.lacak');
Route::post('/ubinan-lacak-proses', [UbinanController::class, 'proses'])->name('ubinan.lacak.proses');
Route::get('/ubinan-lacak-proses', [UbinanController::class, 'proses']);
Route::post('/ubinan/petani/getBySubsegmen/{segmen}/{sub}', [PetaniController::class, 'getBySubsegmen']);
Route::get('/ubinan/petani/getBySubsegmen/{segmen}/{sub}', [PetaniController::class, 'getBySubsegmen']);

Route::get('/ubinan-potensial', [UbinanController::class, 'showPotensial'])->name('ubinan.potensial');

Route::get('/ubinan-unggah', [UbinanController::class, 'showUnggah'])->name('ubinan.unggah');
Route::post('/ubinan/upload', [UbinanController::class, 'import'])->name('ubinan.upload');

Route::get('/ubinan-riwayat', [UbinanController::class, 'showRiwayat'])->name('ubinan.riwayat');
Route::get('/ubinan_detail/{id}/{tahun}/{bulan}', [UbinanController::class, 'showDetail']);

Route::get('/ubinan-panduan', [UbinanController::class, 'showPanduan'])->name('ubinan.panduan');
