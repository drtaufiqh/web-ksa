<?php

namespace App\Http\Controllers;

use App\Models\JagungAmatan;
use App\Models\JagungValidasi;
use App\Models\TahunBulan;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JagungValidasiController extends Controller
{
    public function showValidasi(){
        $wil = Auth::user()->kode;
        if ($wil == '3300') $wil = '33';
        $data = JagungAmatan::where('kode_kabkota', 'like', $wil . '%')->get();
        $allKabKota = User::getAllKabKota();
        $tahun = Carbon::now()->year;
        $bulan = date('m');
        $wil = '3399';

        return view('jagung.validasi', [
            'data' => $data,
            'currentYear' => Carbon::now()->year,
            'allKabKota' => $allKabKota,
            'selected_tahun' => $tahun,
            'selected_bulan' => $bulan,
            'selected_wil' => $wil,
        ]);
    }

    public function getFilteredData(Request $request) {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        $kabkota = Auth::user()->kode;
        if ($kabkota == '3300') $kabkota = $request->input('kabkota');

        $query = DB::table('jagung_amatans'); // Gantilah nama_tabel dengan nama tabel Anda

        if ($tahun) {
            $query->where('tahun', $tahun);
        }

        if ($bulan) {
            $query->where('bulan', $bulan);
        }

        if ($kabkota && $kabkota !== '3300') {
            $query->where('kode_kabkota', $kabkota);
        }

        $data = $query->get();

        return response()->json($data);
    }
}
