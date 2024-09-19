<?php

namespace App\Http\Controllers;

use App\Models\PadiAmatan;
use App\Models\PadiValidasi;
use App\Models\TahunBulan;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PadiValidasiController extends Controller
{
    //
    public function showTestPage()
    {
        return view('test-proses');
    }

    // public function showValidasi(Request $request){
    //     if ($request->isMethod('post')) {
    //         $wil = $request->input('wil');
    //         $tahun = $request->input('tahun');
    //         $bulan = $request->input('bulan');
    //         $tabul1 = $tahun . $bulan;
    //         $tabul0 = TahunBulan::getTabulSebelum($tabul1);
    //         $hasil = $this->proses($wil, $tabul0, $tabul1, 'array', $request);

    //         // Simpan nilai ke session
    //         $request->session()->put('selected_tahun', $tahun);
    //         $request->session()->put('selected_bulan', $bulan);
    //         $request->session()->put('selected_wil', $wil);
    //     } else {
    //         $tahun = $request->session()->get('selected_tahun', Carbon::now()->year);
    //         $bulan = $request->session()->get('selected_bulan', date('m'));
    //         $wil = $request->session()->get('selected_wil', '3399');

    //         // Default tabul values
    //         $tabul1 = $tahun . $bulan;
    //         $tabul0 = TahunBulan::getTabulSebelum($tabul1);
    //         $hasil = $this->proses($wil, $tabul0, $tabul1, 'array', $request);
    //     }

    //     return view('padi.validasi', [
    //         'allKabKota' => User::getAllKabKota(),
    //         'currentYear' => Carbon::now()->year,
    //         'hasil' => $hasil,
    //         'selected_tahun' => $tahun,
    //         'selected_bulan' => $bulan,
    //         'selected_wil' => $wil,
    //     ]);
    // }


    public function showValidasi(){
        $wil = Auth::user()->kode;
        if ($wil == '3300') $wil = '33';
        $data = PadiAmatan::where('kode_kabkota', 'like', $wil . '%')->get();
        // $data = PadiAmatan::paginate(10);
        $allKabKota = User::getAllKabKota();
        $tahun = Carbon::now()->year;
        $bulan = date('m');
        $wil = '3399';
        return view('padi.validasi', [
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
        $tabul = $tahun . $bulan;
        $tabul_sebelum = TahunBulan::getTabulSebelum( $tabul );
        $kabkota = Auth::user()->kode;
        if ($kabkota == '3300') $kabkota = $request->input('kabkota');

        $query = DB::table('paktani_padi_amatans'); // Gantilah nama_tabel dengan nama tabel Anda

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
                    'a3' => null, // Placeholder untuk tabul_sebelum
                    'b1' => null, // Placeholder untuk tabul_sebelum
                    'b2' => null, // Placeholder untuk tabul_sebelum
                    'b3' => null, // Placeholder untuk tabul_sebelum
                    'c1' => null, // Placeholder untuk tabul_sebelum
                    'c2' => null, // Placeholder untuk tabul_sebelum
                    'c3' => null, // Placeholder untuk tabul_sebelum
                    'hasil_a1' => null, // Placeholder untuk tabul_sebelum
                    'fb_a1' => null, // Placeholder untuk tabul_sebelum
                    'hasil_a2' => null, // Placeholder untuk tabul_sebelum
                    'fb_a2' => null, // Placeholder untuk tabul_sebelum
                    'hasil_a3' => null, // Placeholder untuk tabul_sebelum
                    'fb_a3' => null, // Placeholder untuk tabul_sebelum
                    'hasil_b1' => null, // Placeholder untuk tabul_sebelum
                    'fb_b1' => null, // Placeholder untuk tabul_sebelum
                    'hasil_b2' => null, // Placeholder untuk tabul_sebelum
                    'fb_b2' => null, // Placeholder untuk tabul_sebelum
                    'hasil_b3' => null, // Placeholder untuk tabul_sebelum
                    'fb_b3' => null, // Placeholder untuk tabul_sebelum
                    'hasil_c1' => null, // Placeholder untuk tabul_sebelum
                    'fb_c1' => null, // Placeholder untuk tabul_sebelum
                    'hasil_c2' => null, // Placeholder untuk tabul_sebelum
                    'fb_c2' => null, // Placeholder untuk tabul_sebelum
                    'hasil_c3' => null, // Placeholder untuk tabul_sebelum
                    'fb_c3' => null, // Placeholder untuk tabul_sebelum
                    'a1_sblm' => null, // Placeholder untuk tabul_sebelum
                    'a2_sblm' => null, // Placeholder untuk tabul_sebelum
                    'a3_sblm' => null, // Placeholder untuk tabul_sebelum
                    'b1_sblm' => null, // Placeholder untuk tabul_sebelum
                    'b2_sblm' => null, // Placeholder untuk tabul_sebelum
                    'b3_sblm' => null, // Placeholder untuk tabul_sebelum
                    'c1_sblm' => null, // Placeholder untuk tabul_sebelum
                    'c2_sblm' => null, // Placeholder untuk tabul_sebelum
                    'c3_sblm' => null, // Placeholder untuk tabul_sebelum
                    'status' => null,         // Placeholder untuk tabul (bulan saat ini)
                    'evita' => null,         // Placeholder untuk tabul (bulan saat ini)
                    // Kolom lainnya sesuai dengan kebutuhan
                ];
            }

            // Isi data untuk `tabul` atau `tabul_sebelum`
            if ($row->tabul == $tabul_sebelum) {
                $groupedData[$kode_segmen]['a1_sblm'] = $row->a1;
                $groupedData[$kode_segmen]['a2_sblm'] = $row->a2;
                $groupedData[$kode_segmen]['a3_sblm'] = $row->a3;
                $groupedData[$kode_segmen]['b1_sblm'] = $row->b1;
                $groupedData[$kode_segmen]['b2_sblm'] = $row->b2;
                $groupedData[$kode_segmen]['b3_sblm'] = $row->b3;
                $groupedData[$kode_segmen]['c1_sblm'] = $row->c1;
                $groupedData[$kode_segmen]['c2_sblm'] = $row->c2;
                $groupedData[$kode_segmen]['c3_sblm'] = $row->c3;
            } elseif ($row->tabul == $tabul) {
                $groupedData[$kode_segmen]['a1'] = $row->a1;
                $groupedData[$kode_segmen]['a2'] = $row->a2;
                $groupedData[$kode_segmen]['a3'] = $row->a3;
                $groupedData[$kode_segmen]['b1'] = $row->b1;
                $groupedData[$kode_segmen]['b2'] = $row->b2;
                $groupedData[$kode_segmen]['b3'] = $row->b3;
                $groupedData[$kode_segmen]['c1'] = $row->c1;
                $groupedData[$kode_segmen]['c2'] = $row->c2;
                $groupedData[$kode_segmen]['c3'] = $row->c3;
                $groupedData[$kode_segmen]['hasil_a1'] = $row->hasil_a1;
                $groupedData[$kode_segmen]['hasil_a2'] = $row->hasil_a2;
                $groupedData[$kode_segmen]['hasil_a3'] = $row->hasil_a3;
                $groupedData[$kode_segmen]['hasil_b1'] = $row->hasil_b1;
                $groupedData[$kode_segmen]['hasil_b2'] = $row->hasil_b2;
                $groupedData[$kode_segmen]['hasil_b3'] = $row->hasil_b3;
                $groupedData[$kode_segmen]['hasil_c1'] = $row->hasil_c1;
                $groupedData[$kode_segmen]['hasil_c2'] = $row->hasil_c2;
                $groupedData[$kode_segmen]['hasil_c3'] = $row->hasil_c3;
                $groupedData[$kode_segmen]['fb_a1'] = $row->fb_a1;
                $groupedData[$kode_segmen]['fb_a2'] = $row->fb_a2;
                $groupedData[$kode_segmen]['fb_a3'] = $row->fb_a3;
                $groupedData[$kode_segmen]['fb_b1'] = $row->fb_b1;
                $groupedData[$kode_segmen]['fb_b2'] = $row->fb_b2;
                $groupedData[$kode_segmen]['fb_b3'] = $row->fb_b3;
                $groupedData[$kode_segmen]['fb_c1'] = $row->fb_c1;
                $groupedData[$kode_segmen]['fb_c2'] = $row->fb_c2;
                $groupedData[$kode_segmen]['fb_c3'] = $row->fb_c3;
                $groupedData[$kode_segmen]['status'] = $row->status;
                $groupedData[$kode_segmen]['evita'] = $row->evita;
            }
        }

        // Ubah array associative menjadi array biasa
        $finalData = array_values($groupedData);

        return response()->json($finalData);
    }

    function proses($wil=null,$tabul0=null,$tabul1=null,$output='array', Request $request) // output = 'json'
    {
        $err = 1;

        if(!$wil && !empty($request->input('wil')))
            $wil = $request->input('wil');

        if($wil=='3399'){
            if(Auth::user()->role == "prov"){
                $message = array(
                    'status' => false,
                    'message' => 'Silakan pilih kab/kota'
                );
            } else {//ketika digunakan kabkot, hanya bisa untuk kabkot sendiri
                $wil = Auth::user()->kode;
                $err = 0;
            }
        } else {
            if(Auth::user()->role == "prov"){
                $err = 0;
            } else {//ketika digunakan kabkot, tidak bisa memilih wilayah lain
                $message = array(
                    'status' => false,
                    'message' => '403! Access Forbidden!'
                );
            }
        }
        if($err === 0){
            // selain melalui post, biar bisa dipanggil oleh method lain
            if(!$tabul0 && !empty($request->input('tabul0')))
                $tabul0 = $request->input('tabul0');
            if(!$tabul1 && !empty($request->input('tabul1')))
                $tabul1 = $request->input('tabul1');

            $data0 = PadiAmatan::getDataByMultipleField(['tabul' => $tabul0, 'kode_kabkota' => $wil . "%"]);//yg awal
            $data1 = PadiAmatan::getDataByMultipleField(['tabul' => $tabul1, 'kode_kabkota' => $wil . "%"]);//yang baru
            $tmp = '';
            $count_subsegmen = [];
            $count_subsegmen['K'] = 0;
            $count_subsegmen['TK'] = 0;
            $count_subsegmen['W'] = 0;
            $count_subsegmen['Total'] = 0;
            $jenis_subsegmen = ['a1', 'a2', 'a3', 'b1', 'b2', 'b3', 'c1', 'c2', 'c3'];

            //validasi
            if(!empty($data1) && !empty($data0) ){
                $count_segmen = [];
                $count_segmen['K'] = 0;
                $count_segmen['TK'] = 0;
                $evita = [];
                $evita['A'] = 0;
                $evita['R'] = 0;

                $status = [];
                $status['A'] = 0;
                $status['R'] = 0;

                for($i=0; $i < count($data1); $i++){
                    for($j=0; $j < count($data0); $j++){
                        if($data1[$i]['kode_segmen'] == $data0[$j]['kode_segmen']){
                            $tmp = $j;
                            break;
                        }
                    }

                    foreach ($jenis_subsegmen as $jenis) {
                        $data1[$i]['hasil'.$jenis] = $this->validatePadi($data0[$tmp][$jenis],$data1[$i][$jenis]);
                        $data1[$i]['warna'.$jenis] = $this->colorPadi($data1[$i]['hasil'.$jenis]);
                    }

                    $count_seg = 0;
                    foreach ($jenis_subsegmen as $jenis){
                        $var = 'hasil'.$jenis;
                        if($data1[$i][$var] == 'K'){
                            $count_subsegmen['K'] += 1;
                        } else if($data1[$i][$var] == 'W'){
                            $count_subsegmen['W'] += 1;
                        } else if($data1[$i][$var] == 'TK'){
                            $count_subsegmen['TK'] += 1;
                            $count_seg += 1;
                        }
                    }
                    if($count_seg == 0){
                        $count_segmen['K'] += 1;
                    } else {
                        $count_segmen['TK'] += 1;
                    }

                    if($data1[$i]['status'] == 'Approved'){
                        $status['A'] += 1;
                    }
                    if($count_seg == 0 && $data1[$i]['status'] == 'Approved'){
                        $evita['A'] += 1;
                        $data1[$i]['evita'] = 'APPROVED';
                    } else {
                        $evita['R'] += 1;
                        $data1[$i]['evita'] = 'REJECTED';
                    }
                }

                $count_subsegmen['Total'] = $count_subsegmen['K']+$count_subsegmen['TK']+$count_subsegmen['W'];
                $count_segmen['Total'] = $count_segmen['K']+$count_segmen['TK'];
                $evita['Total'] = $evita['A']+$evita['R'];
                $status['R'] = $count_segmen['Total'] - $status['A'];

                $dataVal = array (
                    'indeks' => $tabul1.$wil,
                    'subsegmen_K' => $count_subsegmen['K'],
                    'subsegmen_TK' => $count_subsegmen['TK'],
                    'subsegmen_W' => $count_subsegmen['W'],
                    'subsegmen_total' => $count_segmen['Total'],
                    'segmen_K' => $count_segmen['K'],
                    'segmen_TK' => $count_segmen['TK'],
                    'segmen_total' => $count_segmen['Total'],
                    'status_A' => $status['A'],
                    'status_R' => $status['R'],
                    'status_total' => $count_segmen['Total'],//pasti sama dengan segmen, dan harus sama
                    'evita_A' => $evita['A'],
                    'evita_R' => $evita['R'],
                    'evita_total' => $evita['Total'],
                    'last_update' => date("Y-m-d H:i:s"),
                    'akun' => Auth::user()->email,
                );

                $cekVal = PadiValidasi::getDataByIndeks($tabul1.$wil)->first();
                if($cekVal){
                    $cekVal->update($dataVal);
                } else {
                    PadiValidasi::create($dataVal);
                }

                $message = array(
                    'status' => true,
                    'data1' => $data1,
                    'count_subsegmen' => $count_subsegmen,
                );

            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Data '.$wil.' belum diupload '.sizeof($data0).' - '.sizeof($data1) //__LINE__
                );
            }
        }

        if(request()->ajax()){
            echo json_encode($message);
        // else if ($message['status'] == false){
        //     return $message['message'];
        }else
            return $message;
    }

    function validatePadi($x,$y){
        $hasil = '';
        switch($y){
            case 0:
                $hasil = 'TK';
                break;
            case 1:
                if($x == 2 || $x == 8){
                    $hasil = 'TK';
                } else if($x == 3){
                    $hasil = 'W';
                } else {
                    $hasil = 'K';
                }
                break;
            case 2:
                if($x == 0 || $x == 1){
                    $hasil = 'K';
                } else {
                    $hasil = 'TK';
                }
                break;
            case 3:
                if($x == 0 || $x == 1 || $x == 2 || $x == 3){
                    $hasil = 'K';
                } else {
                    $hasil = "TK";
                }
                break;
            case 4:
                if($x == 0 || $x == 3 || $x == 4){
                    $hasil = 'K';
                } else {
                    $hasil = 'TK';
                }
                break;
            case 5:
                if($x == 1 || $x == 2 || $x == 8){
                    $hasil = 'TK';
                } else if($x == 3){
                    $hasil = 'W';
                } else {
                    $hasil = 'K';
                }
                break;
            case 6:
                if($x == 0 || $x == 6){
                    $hasil = 'K';
                } else if($x == 4 || $x == 7 || $x == 8){
                    $hasil = 'TK';
                } else {
                    $hasil = 'W';
                }
                break;
            case 7:
                if($x == 1 || $x == 2){
                    $hasil = 'W';
                } else if($x == 8){
                    $hasil = 'TK';
                } else {
                    $hasil = 'K';
                }
                break;
            case 8:
                if($x == 0 ||$x == 8){
                    $hasil = 'K';
                } else {
                    $hasil = 'TK';
                }
                break;
            case 12:
                if($x == 0){
                    $hasil = 'K';
                } else {
                    $hasil = 'TK';
                }
                break;
        }
        return $hasil;
    }

    function colorPadi($value){
        if($value == 'K'){
            $color = '#abe96c';
        } else if($value == 'W'){
            $color = '#ffc37c';
        } else {
            $color = '#ff5050';
        }
        return $color;
    }
}
