<?php

use App\Http\Controllers\GambarController;
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
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// padi

// padi_dashboard
Route::get('/padi_dashboard', [PadiAmatanController::class, 'showDashboard'])->middleware('auth')->name('padi_dashboard');

// padi_kondef
Route::get('/padi_kondef', function () {
    return view('padi.kondef');
})->middleware('auth')->name('padi_kondef');
Route::get('/unduh-padi', [GambarController::class, 'unduhPadi'])->middleware('auth');

// padi_unggah
Route::get('/padi_unggah', [PadiAmatanController::class, 'showUploadForm'])->middleware('auth')->name('padi_unggah');
Route::post('/padiamatan/upload', [PadiAmatanController::class, 'import'])->name('padiamatan.upload')->middleware('auth');

// padi_riwayat
Route::get('/padi_riwayat', [PadiAmatanController::class, 'riwayat'])->middleware('auth')->name('padi_riwayat');
Route::get('/padi_detail/{id}/{tahun}/{bulan}', [PadiAmatanController::class, 'showDetail'])->middleware('auth');

// padi_validasi
Route::get('/padi_validasi', [PadiValidasiController::class, 'showValidasi'])->middleware('auth')->name('padi_validasi');
Route::post('/padi_validasi', [PadiValidasiController::class, 'showValidasi'])->middleware('auth')->name('padi_validasi_post');
Route::get('/padi-get-filtered-data', [PadiValidasiController::class, 'getFilteredData'])->middleware('auth');

// padi_petugas
Route::get('/padi_petugas', [PadiAmatanController::class, 'showPetugas'])->middleware('auth')->name('padi_petugas');
Route::get('/padi-get-petugas', [PadiAmatanController::class, 'getPetugas'])->middleware('auth');

// padi_panduan
Route::get('/padi_panduan', function () {
    return view('padi.panduan');
})->middleware('auth')->name('padi_panduan');

Route::post('/padi-get-data-peta', [PadiAmatanController::class, 'getDataPeta'])->middleware('auth')->name('padi.get.data.peta');
Route::get('/padi-get-data-peta-sebaran', [PadiAmatanController::class, 'getDataPetaSebaran'])->middleware('auth')->name('padi.get.data.peta.sebaran');
Route::post('/padi-get-data-peta-sebaran', [PadiAmatanController::class, 'getDataPetaSebaran'])->middleware('auth')->name('padi.get.data.peta.sebaran');
Route::get('/padi-get-data-capaian', [PadiAmatanController::class, 'getDataCapaian'])->middleware('auth');
Route::post('/padi-get-data-progres', [PadiAmatanController::class, 'getDataProgres'])->middleware('auth')->name('padi.get.data.progres');

// testing only
Route::get('/test-proses', [PadiAmatanController::class, 'testProses'])->name('test.proses')->middleware('auth');
Route::post('/test-proses', [PadiAmatanController::class, 'runProses'])->name('run.proses')->middleware('auth');

// jagung

// jagung_dashboard
Route::get('/jagung_dashboard', [JagungAmatanController::class, 'showDashboard'])->middleware('auth')->name('jagung_dashboard');

// jagung_kondef
Route::get('/jagung_kondef', function () {
    return view('jagung.kondef');
})->middleware('auth')->name('jagung_kondef');
Route::get('/unduh-jagung', [GambarController::class, 'unduhJagung'])->middleware('auth');

// jagung_unggah
Route::get('/jagung_unggah', [JagungAmatanController::class, 'showUploadForm'])->middleware('auth')->name('jagung_unggah');
Route::post('/jagungamatan/upload', [JagungAmatanController::class, 'import'])->middleware('auth')->name('jagungamatan.upload');
Route::post('/jagungamatan/upfeedback', [JagungAmatanController::class, 'importFeedback'])->middleware('auth')->name('jagungamatan.upfeedback');

// jagung_riwayat
Route::get('/jagung_riwayat', [JagungAmatanController::class, 'riwayat'])->middleware('auth')->name('jagung_riwayat');
Route::get('/jagung_detail/{id}/{tahun}/{bulan}', [JagungAmatanController::class, 'showDetail'])->middleware('auth');

// jagung_validasi
Route::get('/jagung_validasi', [JagungValidasiController::class, 'showValidasi'])->middleware('auth')->name('jagung_validasi');
Route::post('/jagung_validasi', [JagungValidasiController::class, 'showValidasi'])->middleware('auth')->name('jagung_validasi_post');
Route::get('/get-filtered-data', [JagungValidasiController::class, 'getFilteredData'])->middleware('auth');

// jagung_petugas
Route::get('/jagung_petugas', [JagungAmatanController::class, 'showPetugas'])->middleware('auth')->name('jagung_petugas');
Route::get('/jagung_petugas', [JagungAmatanController::class, 'showPetugas'])->middleware('auth')->name('jagung_petugas');
Route::get('/jagung-get-petugas', [JagungAmatanController::class, 'getPetugas'])->middleware('auth');

// jagung_panduan
Route::get('/jagung_panduan', function () {
    return view('jagung.panduan');
})->middleware('auth')->name('jagung_panduan');


Route::post('/jagung-get-data-peta', [JagungAmatanController::class, 'getDataPeta'])->middleware('auth')->name('jagung.get.data.peta');
Route::get('/jagung-get-data-peta-sebaran', [JagungAmatanController::class, 'getDataPetaSebaran'])->middleware('auth');
Route::post('/jagung-get-data-peta-sebaran', [JagungAmatanController::class, 'getDataPetaSebaran'])->middleware('auth')->name('jagung.get.data.peta.sebaran');
Route::get('/jagung-get-data-capaian', [JagungAmatanController::class, 'getDataCapaian'])->middleware('auth');
Route::post('/jagung-get-data-progres', [JagungAmatanController::class, 'getDataProgres'])->middleware('auth')->name('jagung.get.data.progres');
Route::get('/jagung-get-data-progres', [JagungAmatanController::class, 'getDataProgres'])->middleware('auth')->name('jagung.get.data.progres');

// ubinan

Route::get('/ubinan-lacak', [UbinanController::class, 'showLacak'])->middleware('auth')->name('ubinan.lacak');
Route::post('/ubinan-lacak-proses', [UbinanController::class, 'proses'])->middleware('auth')->name('ubinan.lacak.proses');
Route::get('/ubinan-lacak-proses', [UbinanController::class, 'proses'])->middleware('auth');
Route::post('/ubinan/petani/getBySubsegmen/{segmen}/{sub}', [PetaniController::class, 'getBySubsegmen'])->middleware('auth');
Route::get('/ubinan/petani/getBySubsegmen/{segmen}/{sub}', [PetaniController::class, 'getBySubsegmen'])->middleware('auth');
Route::post('/ubinan/petani/insertPetani', [PetaniController::class, 'insertPetani'])->middleware('auth');
Route::get('/ubinan/petani/insertPetani', [PetaniController::class, 'insertPetani'])->middleware('auth');
Route::post('/ubinan/petani/deletePetani', [PetaniController::class, 'deletePetani'])->middleware('auth');
Route::get('/ubinan/petani/deletePetani', [PetaniController::class, 'deletePetani'])->middleware('auth');

Route::get('/ubinan-potensial', [UbinanController::class, 'showPotensial'])->middleware('auth')->name('ubinan.potensial');

Route::get('/ubinan-kelola', [UbinanController::class, 'showKelola'])->middleware('auth')->name('ubinan.kelola');
Route::post('/ubinan/lacak/cadangan', [UbinanController::class, 'cadangan'])->middleware('auth');
Route::get('/ubinan/lacak/cadangan', [UbinanController::class, 'cadangan'])->middleware('auth');

Route::get('/ubinan-unggah', [UbinanController::class, 'showUnggah'])->middleware('auth')->name('ubinan.unggah');
Route::post('/ubinan/upload', [UbinanController::class, 'import'])->middleware('auth')->name('ubinan.upload');

Route::get('/ubinan-riwayat', [UbinanController::class, 'showRiwayat'])->middleware('auth')->name('ubinan.riwayat');
Route::get('/ubinan_detail/{id}/{tahun}/{bulan}', [UbinanController::class, 'showDetail'])->middleware('auth');

Route::get('/ubinan-panduan', [UbinanController::class, 'showPanduan'])->middleware('auth')->name('ubinan.panduan');

Route::get('/ubinan/petani/getAll', [PetaniController::class, 'getAll'])->middleware('auth');
