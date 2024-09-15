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

    // public function getFilteredData(Request $request) {
    //     $tahun = $request->input('tahun');
    //     $bulan = $request->input('bulan');
    //     $kabkota = Auth::user()->kode;
    //     if ($kabkota == '3300') $kabkota = $request->input('kabkota');

    //     $query = DB::table('jagung_amatans'); // Gantilah nama_tabel dengan nama tabel Anda

    //     if ($tahun) {
    //         $query->where('tahun', $tahun);
    //     }

    //     if ($bulan) {
    //         $query->where('bulan', $bulan);
    //     }

    //     if ($kabkota && $kabkota !== '3300') {
    //         $query->where('kode_kabkota', $kabkota);
    //     }

    //     $data = $query->get();

    //     return response()->json($data);
    // }


    public function getFilteredData(Request $request) {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        $tabul = $tahun . $bulan;
        $tabul_sebelum = TahunBulan::getTabulSebelum( $tabul );
        $kabkota = Auth::user()->kode;
        if ($kabkota == '3300') $kabkota = $request->input('kabkota');

        $query = DB::table('jagung_amatans'); // Gantilah nama_tabel dengan nama tabel Anda

        // if ($tabul_sebelum && $tabul_sebelum) {
        $query->whereIn('tabul', [$tabul_sebelum, $tabul]);
        // }

        // if ($bulan) {
        //     $query->where('bulan', $bulan);
        // }

        if ($kabkota && $kabkota !== '3300') {
            $query->where('kode_kabkota', $kabkota);
        }

        $data = $query->get();

        // return response()->json($data);
        // Proses penggabungan data
        $groupedData = [];

        foreach ($data as $row) {
            $kode_segmen = $row->kode_segmen; // Misalkan 'indeks' adalah identifier untuk data
            if (!isset($groupedData[$kode_segmen])) {
                // Inisialisasi baris baru jika belum ada
                $groupedData[$kode_segmen] = [
                    'kode_segmen' => $row->kode_segmen,
                    'a1' => null, // Placeholder untuk tabul_sebelum
                    'a2' => null, // Placeholder untuk tabul_sebelum
                    'b1' => null, // Placeholder untuk tabul_sebelum
                    'b2' => null, // Placeholder untuk tabul_sebelum
                    'hasil_a1' => null, // Placeholder untuk tabul_sebelum
                    'hasil_a2' => null, // Placeholder untuk tabul_sebelum
                    'hasil_b1' => null, // Placeholder untuk tabul_sebelum
                    'hasil_b2' => null, // Placeholder untuk tabul_sebelum
                    'a1_sblm' => null, // Placeholder untuk tabul_sebelum
                    'a2_sblm' => null, // Placeholder untuk tabul_sebelum
                    'b1_sblm' => null, // Placeholder untuk tabul_sebelum
                    'b2_sblm' => null, // Placeholder untuk tabul_sebelum
                    'feedback' => null, // Placeholder untuk tabul_sebelum
                    'status' => null,         // Placeholder untuk tabul (bulan saat ini)
                    'evita' => null,         // Placeholder untuk tabul (bulan saat ini)
                    // Kolom lainnya sesuai dengan kebutuhan
                ];
            }

            // Isi data untuk `tabul` atau `tabul_sebelum`
            if ($row->tabul == $tabul_sebelum) {
                $groupedData[$kode_segmen]['a1_sblm'] = $row->a1;
                $groupedData[$kode_segmen]['a2_sblm'] = $row->a2;
                $groupedData[$kode_segmen]['b1_sblm'] = $row->b1;
                $groupedData[$kode_segmen]['b2_sblm'] = $row->b2;
            } elseif ($row->tabul == $tabul) {
                $groupedData[$kode_segmen]['a1'] = $row->a1;
                $groupedData[$kode_segmen]['a2'] = $row->a2;
                $groupedData[$kode_segmen]['b1'] = $row->b1;
                $groupedData[$kode_segmen]['b2'] = $row->b2;
                $groupedData[$kode_segmen]['hasil_a1'] = $row->hasil_a1;
                $groupedData[$kode_segmen]['hasil_a2'] = $row->hasil_a2;
                $groupedData[$kode_segmen]['hasil_b1'] = $row->hasil_b1;
                $groupedData[$kode_segmen]['hasil_b2'] = $row->hasil_b2;
                $groupedData[$kode_segmen]['feedback'] = $row->feedback;
                $groupedData[$kode_segmen]['status'] = $row->status;
                $groupedData[$kode_segmen]['evita'] = $row->evita;
            }
        }

        // Ubah array associative menjadi array biasa
        $finalData = array_values($groupedData);

        return response()->json($finalData);
    }

}
