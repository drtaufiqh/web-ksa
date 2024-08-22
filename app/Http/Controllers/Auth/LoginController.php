<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
