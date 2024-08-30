<?php

namespace App\Http\Controllers;

use App\Models\TahunBulan;
use Illuminate\Http\Request;
use App\Http\Requests\UploadPadiAmatanRequest;
use App\Imports\PadiAmatanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Models\PadiAmatan;
use App\Models\PadiValidasi;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PadiAmatanController extends Controller
{
    public function showUploadForm(){
        // Ambil tahun terkecil dari database
        $minYear = PadiAmatan::min('tahun');

        // Tahun sekarang
        $currentYear = Carbon::now()->addHours(7)->year;

        // Kirim tahun terkecil dan tahun sekarang ke view
        return view('padi.unggah', [
            'minYear' => $minYear-1,
            'currentYear' => $currentYear,
        ]);
    }

    public function import(Request $request){
        // Validasi file
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Ambil file
        $file = $request->file('file');
        $bulanInput = $request->input('bulan');
        $tahunInput = $request->input('tahun');
        $tabulInput = $tahunInput . $bulanInput;
        
        // Ambil nama file dan ambil 4 karakter pertama
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $tahun = substr($fileName, 0, 4);
        $bulan = substr($fileName, 4, 2);
        $tabul = substr($fileName, 0, 6);
        // dd($bulanInput == $bulan);
        if ($tabulInput != $tabul) {
            return back()->withErrors(['input' => 'Pastikan format file sesuai dengan tahun dan bulan yang dipilih!'])->withInput();
        }

        // Baca file excel
        $data = Excel::toArray([], $file);

        // Ambil header (baris pertama) dari file excel
        $header = array_map('trim', $data[0][0]);

        // Tentukan header yang diharapkan
        $expectedHeader = [
            'id segmen', 'subsegmen', 'nama', 'n-3', 'n-2', 'n-1', 'n', 'amatan', 'status', 'evaluasi', 'tanggal', 'flag kode 12', 'note'
        ];

        // Validasi header
        if ($header !== $expectedHeader) {
            return back()->withErrors(['file' => 'Format kolom Excel tidak sesuai.'])->withInput();
        }

        // // Pemetaan indeks header untuk akses data
        $headerIndexes = array_flip($header);
        $groupedData = [];

        // Proses data jika validasi sukses
        foreach ($data[0] as $key => $row) {
            if ($key == 0) {
                continue; // Lewatkan header
            }

            if (isset($headerIndexes['id segmen'], $headerIndexes['nama'], $headerIndexes['subsegmen'], $headerIndexes['status'], $headerIndexes['amatan'])) {
                $indeks = $tabul . $row[$headerIndexes['id segmen']];
                $pcs = $row[$headerIndexes['nama']];
                $kode_segmen = $row[$headerIndexes['id segmen']];
                $kode_kabkota = substr($kode_segmen, 0, 4);
                $status = $row[$headerIndexes['status']];
                $subsegmen = $row[$headerIndexes['subsegmen']];

                $amatan = $row[$headerIndexes['amatan']];
                $parts = explode('.', $amatan);
                $nValue = $parts[0];

                // Pemetaan subsegmen ke kolom database
                $mapping = [
                    'A1' => 'a1',
                    'A2' => 'a2',
                    'A3' => 'a3',
                    'B1' => 'b1',
                    'B2' => 'b2',
                    'B3' => 'b3',
                    'C1' => 'c1',
                    'C2' => 'c2',
                    'C3' => 'c3',
                ];

                // Gabungkan data dengan subsegmen yang sesuai dalam satu baris
                if (!isset($groupedData[$indeks])) {
                    $groupedData[$indeks] = [
                        'indeks' => $indeks,
                        'tabul' => $tabul,
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                        'kode_segmen' => $kode_segmen,
                        'kode_kabkota' => $kode_kabkota,
                        'pcs' => $pcs,
                        'status' => $status,
                        'akun' => Auth::user()->email,
                        'updated_at' => Carbon::now()->addHours(7)->format('Y-m-d H:i:s'),
                    ];
                }

                $groupedData[$indeks][$mapping[$subsegmen]] = $nValue; // Gabungkan data
            } else {
                // Tangani kasus jika kunci header tidak ada dalam data
                return back()->withErrors(['file' => 'Kolom yang diperlukan tidak ada dalam file Excel.'])->withInput();
            }
        }

        // Masukkan data yang sudah digabung ke dalam database
        foreach ($groupedData as $dataToInsert) {
            $kodekab = $dataToInsert['kode_kabkota'];
            if (Auth::user()->role == 'prov' || Auth::user()->kode == $kodekab){
                // Periksa apakah entri dengan kode_segmen yang sama sudah ada
                $existingRecord = PadiAmatan::where('indeks', $dataToInsert['indeks'])->first();

                if ($existingRecord) {
                    // Jika sudah ada, perbarui data
                    $existingRecord->update($dataToInsert);
                } else {
                    // Jika tidak ada, buat entri baru
                    PadiAmatan::create($dataToInsert);
                }
            }
        }

        $tabul_sebelum = TahunBulan::getTabulSebelum($tabul);
        $tabul_sesudah = TahunBulan::getTabulSesudah($tabul);
        $message_sebelum = $this->proses($tabul_sebelum, $tabul);
        $message_sesudah = $this->proses($tabul, $tabul_sesudah);

        return redirect()->back()->with('success', 'Data berhasil diunggah.');
    }

    public function riwayat(){
        // $data = PadiAmatan::all();
        // $data = PadiAmatan::paginate(10);
        $allKabKota = User::getAllKabKota();
        $data = DB::table('padi_amatans')
            ->join('users', 'padi_amatans.kode_kabkota', '=', 'users.kode')
            ->selectRaw('CONCAT(padi_amatans.kode_kabkota, " - ", users.nama) as kab_kota, padi_amatans.kode_kabkota as kode_kabkota, padi_amatans.tahun, padi_amatans.bulan, COUNT(*) as baris, MAX(padi_amatans.updated_at) as last_update')
            ->groupBy('padi_amatans.kode_kabkota', 'padi_amatans.tahun', 'padi_amatans.bulan', 'users.nama')
            ->get();
        return view('padi.riwayat', [
            'data' => $data,
            'allKabKota' => $allKabKota,
        ]);
    }

    public function showDetail($id){
        // Ambil data detail dari database berdasarkan ID
        $data = PadiAmatan::where('kode_kabkota', $id)->get(); // Sesuaikan dengan query Anda
        
        // Kirimkan data dalam format JSON
        return response()->json([
            'data' => $data
        ]);
    }

    public function testProses()
    {
        return view('test-proses');
    }

    public function runProses(Request $request)
    {
        $tabul0 = $request->input('tabul0');
        $tabul1 = $request->input('tabul1');

        $result = $this->proses($tabul0, $tabul1);

        return view('test-proses', compact('result'));
    }

    function proses($tabul0=null,$tabul1=null)
    {
        $data0 = PadiAmatan::getDataByMultipleField(['tabul' => $tabul0]);//yg awal
        $data1 = PadiAmatan::getDataByMultipleField(['tabul' => $tabul1]);//yang baru
        $tmp = '';
        $count_subsegmen = [];
        $count_subsegmen['K'] = 0;
        $count_subsegmen['TK'] = 0;
        $count_subsegmen['W'] = 0;
        $count_subsegmen['Total'] = 0;
        $jenis_subsegmen = ['a1', 'a2', 'a3', 'b1', 'b2', 'b3', 'c1', 'c2', 'c3'];

        //validasi
        if(!$data1->isEmpty() && !$data0->isEmpty()){
            $count_segmen = [];
            $count_segmen['K'] = 0;
            $count_segmen['TK'] = 0;
            $evita = [];
            $evita['A'] = 0;
            $evita['R'] = 0;
            
            $status = [];
            $status['A'] = 0;
            $status['R'] = 0;

            $uniqueKodeKabkota = $data1->pluck('kode_kabkota')->unique()->toArray();

            foreach ($uniqueKodeKabkota as $wil) {
                $filteredData1 = $data1->filter(function ($item) use ($wil) {
                    return $item['kode_kabkota'] === $wil;
                })->values();
                $filteredData0 = $data0->filter(function ($item) use ($wil) {
                    return $item['kode_kabkota'] === $wil;
                })->values();
                
                if(!$filteredData1->isEmpty() && !$filteredData0->isEmpty()){
                    foreach ($filteredData1 as $i => $row1) {
                    // for($i=0; $i < count($filteredData1); $i++){
                        foreach ($filteredData0 as $j => $row0) {
                        // for($j=0; $j < count($filteredData0); $j++){
                            if($filteredData1[$i]['kode_segmen'] == $filteredData0[$j]['kode_segmen']){
                                $tmp = $j;
                                break;
                            }
                        }

                        foreach ($jenis_subsegmen as $jenis) {
                            $filteredData1[$i]['hasil_'.$jenis] = $this->validatePadi($filteredData0[$tmp][$jenis],$filteredData1[$i][$jenis]);
                        }

                        $count_seg = 0;
                        foreach ($jenis_subsegmen as $jenis){                            
                            $var = 'hasil_'.$jenis;
                            if($filteredData1[$i][$var] == 'K'){
                                $count_subsegmen['K'] += 1;
                            } else if($filteredData1[$i][$var] == 'W'){
                                $count_subsegmen['W'] += 1;
                            } else if($filteredData1[$i][$var] == 'TK'){
                                $count_subsegmen['TK'] += 1;
                                $count_seg += 1;
                            }
                        }
                        if($count_seg == 0){
                            $count_segmen['K'] += 1;
                        } else {
                            $count_segmen['TK'] += 1;
                        }
                        
                        if($filteredData1[$i]['status'] == 'Approved'){
                            $status['A'] += 1;
                        }
                        if($count_seg == 0 && $filteredData1[$i]['status'] == 'Approved'){
                            $evita['A'] += 1;
                            $filteredData1[$i]['evita'] = 'APPROVED';
                        } else {
                            $evita['R'] += 1;
                            $filteredData1[$i]['evita'] = 'REJECTED';
                        }
                        
                        $dataUpdate = array(
                            'hasil_a1' => $filteredData1[$i]['hasil_a1'],
                            'hasil_a2' => $filteredData1[$i]['hasil_a2'],
                            'hasil_a3' => $filteredData1[$i]['hasil_a3'],
                            'hasil_b1' => $filteredData1[$i]['hasil_b1'],
                            'hasil_b2' => $filteredData1[$i]['hasil_b2'],
                            'hasil_b3' => $filteredData1[$i]['hasil_b3'],
                            'hasil_c1' => $filteredData1[$i]['hasil_c1'],
                            'hasil_c2' => $filteredData1[$i]['hasil_c2'],
                            'hasil_c3' => $filteredData1[$i]['hasil_c3'],
                            'evita' => $filteredData1[$i]['evita'],
                        );
                        PadiAmatan::where('indeks', $tabul1 . $filteredData1[$i]['kode_segmen'])->first()->update($dataUpdate);
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
                        'subsegmen_total' => $count_subsegmen['Total'],
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
                }
            }

            $message = array(
                'status' => true,
                'data1' => $data1,
                'count_subsegmen' => $count_subsegmen,
            );

        } else {
            $message = array(
                'status' => false,
                'message' => 'Data ada yang belum diupload data ' . $tabul0 . ': '.sizeof($data0).' - data ' . $tabul1 . ': ' .sizeof($data1) //__LINE__
            );
        }

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
}
