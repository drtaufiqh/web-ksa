<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Petani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Function untuk menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Function untuk menangani proses login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba untuk melakukan login
        if (Auth::attempt($credentials)) {
            // Jika berhasil login, regenerate session
            $request->session()->regenerate();

            $wil = Auth::user()->kode;
            if ($wil == '3300') {
                $wil = '33';
            }
            // Ambil tanggal saat ini
            $today = now()->startOfDay(); // Mulai dari awal hari
            // Tambah 7 hari
            $sevenDaysLater = $today->copy()->addDays(7);

            // Cek data yang tanggalnya antara hari ini dan 7 hari ke depan
            $petani = Petani::where('kode_segmen', 'like', $wil . '%')
                ->whereBetween('tanggal', [$today->format('Y-m-d'), $sevenDaysLater->format('Y-m-d')])
                ->get();

            // Jika ada data yang cocok
            if ($petani->count() > 0) {
                // Simpan pesan notifikasi ke session
                session()->flash('notification', 'Ada data petani yang akan jatuh tempo dalam 7 hari.');
            }

            // Redirect ke halaman yang seharusnya
            return redirect()->intended('dashboard');
        }

        // Jika login gagal, redirect kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Masukkan email dan password dengan benar!',
        ])->onlyInput('email');
    }

    // Function untuk menangani logout
    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect('/login');
    }
}
