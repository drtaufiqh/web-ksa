<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PadiAmatanController;

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
    // return view('welcome');
    return redirect('login');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

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
Route::post('/padiamatan/upload', [PadiAmatanController::class, 'uploadExcel'])->name('padiamatan.upload');

Route::get('/padi_riwayat', function () {
    return view('padi.riwayat');
})->middleware('auth')->name('padi_riwayat');

Route::get('/padi_validasi', function () {
    return view('padi.validasi');
})->middleware('auth')->name('padi_validasi');

Route::get('/padi_panduan', function () {
    return view('padi.panduan');
})->middleware('auth')->name('padi_panduan');