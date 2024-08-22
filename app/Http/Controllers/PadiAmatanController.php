<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadPadiAmatanRequest;
use App\Imports\PadiAmatanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class PadiAmatanController extends Controller
{
    public function showUploadForm()
    {
        return view('padi.unggah');
    }

    public function uploadExcel(Request $request)
    {
        $import = new PadiAmatanImport();

        try {
            Excel::import($import, $request->file('file'));

            if (session('error')) {
                return redirect()->back()->with('error', session('error'));
            }

            return redirect()->back()->with('success', 'File berhasil diunggah dan data telah dimasukkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'File Excel tidak valid atau kolom tidak sesuai.');
        }
    }
}
