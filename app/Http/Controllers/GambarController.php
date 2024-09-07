<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GambarController extends Controller
{
    public function unduhJagung()
    {
        // Lokasi file gambar
        $filename = public_path('assets/img/rule3300_jagung.png');

        // Cek apakah file ada
        if (file_exists($filename)) {
            // Jika ada, unduh file
            return response()->download($filename);
        } else {
            // Jika file tidak ditemukan, kembali dengan pesan error
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    }
    public function unduhPadi()
    {
        // Lokasi file gambar
        $filename = public_path('assets/img/rule3300_padi.png');

        // Cek apakah file ada
        if (file_exists($filename)) {
            // Jika ada, unduh file
            return response()->download($filename);
        } else {
            // Jika file tidak ditemukan, kembali dengan pesan error
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    }
}
