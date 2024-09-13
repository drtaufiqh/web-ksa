<?php

namespace App\Http\Controllers;

use App\Models\TahunBulan;
use Illuminate\Http\Request;
use App\Http\Requests\UploadJagungAmatanRequest;
use App\Imports\JagungAmatanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Models\JagungAmatan;
use App\Models\JagungValidasi;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JagungAmatanController extends Controller
{
    public function getPetugas(Request $request) {
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

        $data = $query->select(
            'pcs',
            DB::raw('COUNT(*) as target'), // Menghitung jumlah total record (target)
            DB::raw('SUM(CASE
                        WHEN a1 IS NOT NULL
                            AND a2 IS NOT NULL
                            AND b1 IS NOT NULL
                            AND b2 IS NOT NULL
                        THEN 1 ELSE 0 END) as realisasi'), // Menghitung realisasi
            DB::raw('(SUM(CASE
                            WHEN a1 IS NOT NULL
                                AND a2 IS NOT NULL
                                AND b1 IS NOT NULL
                                AND b2 IS NOT NULL
                            THEN 1 ELSE 0 END) / COUNT(*) * 100) as progres') // Menghitung progres
        )
        ->groupBy('pcs')
        ->get();

        return response()->json($data);
    }

    public function showPetugas(){
        $wil = Auth::user()->kode;
        if ($wil == '3300') $wil = '33';
        $data = JagungAmatan::where('kode_kabkota', 'like', $wil . '%')->get();
        // $data = JagungAmatan::paginate(10);
        $allKabKota = User::getAllKabKota();
        $tahun = Carbon::now()->year;
        $bulan = date('m');
        $wil = '3399';
        return view('jagung.petugas', [
            'data' => $data,
            'currentYear' => Carbon::now()->year,
            'allKabKota' => $allKabKota,
            'selected_tahun' => $tahun,
            'selected_bulan' => $bulan,
            'selected_wil' => $wil,
        ]);
    }

    public function showDashboard(){
        // Ambil tahun terkecil dari database
        $minYear = JagungAmatan::min('tahun') ?? Carbon::now()->year;

        // Tahun sekarang
        $currentYear = Carbon::now()->year;

        // Kirim tahun terkecil dan tahun sekarang ke view
        return view('jagung.dashboard', [
            'minYear' => $minYear-1,
            'currentYear' => $currentYear,
        ]);
    }

    public function showUploadForm(){
        // Ambil tahun terkecil dari database
        $minYear = JagungAmatan::min('tahun') ?? Carbon::now()->year;

        // Tahun sekarang
        $currentYear = Carbon::now()->year;

        // Kirim tahun terkecil dan tahun sekarang ke view
        return view('jagung.unggah', [
            'minYear' => $minYear-1,
            'currentYear' => $currentYear,
        ]);
    }

    public function import(Request $request){
        set_time_limit(4 * 60); // Mengatur maksimum waktu eksekusi menjadi 4 menit

        $wil = Auth::user()->kode;

        // Validasi file
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        if ($validator->fails()) {
            // Ambil format file yang diupload
            $file = $request->file('file');
            $uploadedFileExtension = $file->getClientOriginalExtension();

            // Format pesan error
            $errorMessage = 'File yang diupload harus dalam format: xlsx. Sedangkan file yang Anda upload adalah format ' . $uploadedFileExtension . '.';

            return back()->withErrors(['file' => $errorMessage])->withInput();
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
        $tabul_sesudah = TahunBulan::getTabulSesudah($tabul);
        $tabul_n_1 =TahunBulan::getTabulSebelum($tabul);
        $wilFile = substr($fileName, 8, 4);
        $jenis = substr($fileName, 13, 6);

        if (($wil != '3300') && ($wil != $wilFile)) {
            return back()->withErrors(['input' => 'Pastikan format file sesuai dengan kabupaten/kota!'])->withInput();
        }
        if ($jenis != 'jagung') {
            return back()->withErrors(['input' => 'Pastikan format file sesuai!'])->withInput();
        }

        if ($tabulInput != $tabul) {
            return back()->withErrors(['input' => 'Pastikan format file sesuai dengan tahun dan bulan yang dipilih!'])->withInput();
        }

        // Baca file excel
        $data = Excel::toArray([], $file);

        // Ambil header (baris pertama) dari file excel
        $header = array_map('trim', $data[0][0]);

        // Tentukan header minimal yang diharapkan
        $requiredHeader = [
            'Kode Segmen', 'Nilai A1', 'Nilai A2', 'Nilai B1', 'Nilai B2', 'Nama Petugas', 'Status'
        ];

        // Validasi header
        foreach ($requiredHeader as $requiredColumn) {
            if (!in_array($requiredColumn, $header)) {
                return back()->withErrors(['file' => 'Format kolom Excel tidak sesuai. Kolom ' . $requiredColumn . ' tidak ditemukan.'])->withInput();
            }
        }

        // // Pemetaan indeks header untuk akses data
        $headerIndexes = array_flip($header);
        $groupedData = [];

        // Proses data jika validasi sukses
        foreach ($data[0] as $key => $row) {
            if ($key == 0) {
                continue; // Lewatkan header
            }
            $pcs = $row[$headerIndexes['Nama Petugas']];
            $kode_segmen = $row[$headerIndexes['Kode Segmen']];
            $indeks = $tabul . $kode_segmen;
            $kode_kabkota = substr($kode_segmen, 0, 4);
            $status = $row[$headerIndexes['Status']];
            $a1 = $row[$headerIndexes['Nilai A1']];
            $a2 = $row[$headerIndexes['Nilai A2']];
            $b1 = $row[$headerIndexes['Nilai B1']];
            $b2 = $row[$headerIndexes['Nilai B2']];

            $groupedData[$indeks] = [
                'indeks' => $indeks,
                'tabul' => $tabul,
                'tahun' => $tahun,
                'bulan' => $bulan,
                'kode_segmen' => $kode_segmen,
                'kode_kabkota' => $kode_kabkota,
                'a1' => $a1,
                'a2' => $a2,
                'b1' => $b1,
                'b2' => $b2,
                'pcs' => $pcs,
                'status' => $status,
                'akun' => Auth::user()->email,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ];
        }

        // Masukkan data yang sudah digabung ke dalam database
        foreach ($groupedData as $dataToInsert) {
            $kodekab = $dataToInsert['kode_kabkota'];
            if (Auth::user()->role == 'prov' || Auth::user()->kode == $kodekab){
                // Periksa apakah entri dengan kode_segmen yang sama sudah ada
                $existingRecord = JagungAmatan::where('indeks', $dataToInsert['indeks'])->first();

                if ($existingRecord) {
                    // Jika sudah ada, perbarui data
                    $existingRecord->update($dataToInsert);
                } else {
                    // Jika tidak ada, buat entri baru
                    JagungAmatan::create($dataToInsert);
                }
            }
        }

        $message_sesudah = $this->proses($tabul, $tabul_sesudah);
        $message_n = $this->proses($tabul_n_1, $tabul);

        return redirect()->back()->with('success', 'Data jagung ' . $tabul . ' berhasil diunggah.')->withInput();
    }

    public function importFeedback(Request $request){
        $wil = Auth::user()->kode;
        // Validasi file
        $validator = Validator::make($request->all(), [
            'file_fb' => 'required|mimes:xls,xlsx,csv',
        ]);

        if ($validator->fails()) {
            // Ambil format file yang diupload
            $file = $request->file('file_fb');
            $uploadedFileExtension = $file->getClientOriginalExtension();

            // Format pesan error
            $errorMessage = 'File yang diupload harus dalam format: xlsx. Sedangkan file yang Anda upload adalah format ' . $uploadedFileExtension . '.';

            return back()->withErrors(['file' => $errorMessage])->withInput();
        }

        // Ambil file
        $file = $request->file('file_fb');
        $bulanInput = $request->input('bulan_fb');
        $tahunInput = $request->input('tahun_fb');
        $tabulInput = $tahunInput . $bulanInput;

        // Ambil nama file dan ambil 4 karakter pertama
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $tahun = substr($fileName, 0, 4);
        $bulan = substr($fileName, 4, 2);
        $tabul = substr($fileName, 0, 6);
        $wilFile = substr($fileName, 8, 4);
        $jenis = substr($fileName, 13, 6);

        if (($wil != '3300') && ($wil != $wilFile)) {
            return back()->withErrors(['input' => 'Pastikan format file sesuai dengan kabupaten/kota!'])->withInput();
        }
        if ($jenis != 'jagung') {
            return back()->withErrors(['input' => 'Pastikan format file sesuai!'])->withInput();
        }

        if ($tabulInput != $tabul) {
            return back()->withErrors(['input' => 'Pastikan format file sesuai dengan tahun dan bulan yang dipilih!'])->withInput();
        }

        // Baca file excel
        $data = Excel::toArray([], $file);

        // Ambil header (baris pertama) dari file excel
        $header = array_map('trim', $data[0][0]);

        // Tentukan header minimal yang diharapkan
        $requiredHeader = [
            'Kode Segmen', 'Feedback'
        ];

        // Validasi header
        foreach ($requiredHeader as $requiredColumn) {
            if (!in_array($requiredColumn, $header)) {
                return back()->withErrors(['file' => 'Format kolom Excel tidak sesuai. Kolom ' . $requiredColumn . ' tidak ditemukan.'])->withInput();
            }
        }

        // // Pemetaan indeks header untuk akses data
        $headerIndexes = array_flip($header);
        $groupedData = [];

        // Proses data jika validasi sukses
        foreach ($data[0] as $key => $row) {
            if ($key == 0) {
                continue; // Lewatkan header
            }
            $kode_segmen = $row[$headerIndexes['Kode Segmen']];
            $feedback = $row[$headerIndexes['Feedback']];
            $indeks = $tabul . $kode_segmen;
            $kode_kabkota = substr($kode_segmen, 0, 4);

            $groupedData[$indeks] = [
                'indeks' => $indeks,
                'tahun' => $tahun,
                'bulan' => $bulan,
                'kode_segmen' => $kode_segmen,
                'kode_kabkota' => $kode_kabkota,
                'feedback' => $feedback,
                'akun' => Auth::user()->email,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ];
        }

        // Masukkan data yang sudah digabung ke dalam database
        foreach ($groupedData as $dataToInsert) {
            $kodekab = $dataToInsert['kode_kabkota'];
            if (Auth::user()->role == 'prov' || Auth::user()->kode == $kodekab){
                // Periksa apakah entri dengan kode_segmen yang sama sudah ada
                $existingRecord = JagungAmatan::where('indeks', $dataToInsert['indeks'])->first();

                if ($existingRecord) {
                    // Jika sudah ada, perbarui data
                    $existingRecord->update($dataToInsert);
                } else {
                    // Jika tidak ada, buat entri baru
                    JagungAmatan::create($dataToInsert);
                }
            }
        }

        return redirect()->back()->with('success', 'Feedback jagung ' . $tabul . ' berhasil diunggah.')->withInput();
    }

    public function riwayat(){
        $wil = Auth::user()->kode;
        if ($wil == '3300') $wil = '33';
        $allKabKota = User::getAllKabKota();
        $data = DB::table('jagung_amatans')
            ->join('users', 'jagung_amatans.kode_kabkota', '=', 'users.kode')
            ->selectRaw('CONCAT(jagung_amatans.kode_kabkota, " - ", users.nama) as kab_kota, jagung_amatans.kode_kabkota as kode_kabkota, jagung_amatans.tahun, jagung_amatans.bulan, COUNT(*) as baris, MAX(jagung_amatans.updated_at) as last_update')
            ->groupBy('jagung_amatans.kode_kabkota', 'jagung_amatans.tahun', 'jagung_amatans.bulan', 'users.nama')
            ->where('kode_kabkota', 'like', $wil . '%')
            ->get();
        return view('jagung.riwayat', [
            'data' => $data,
            'allKabKota' => $allKabKota,
        ]);
    }

    public function showDetail($id, $tahun, $bulan){
        // Ambil data detail dari database berdasarkan ID
        $data = JagungAmatan::where('kode_kabkota', $id)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->get(); // Sesuaikan dengan query Anda

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
        $data0 = JagungAmatan::getDataByMultipleField(['tabul' => $tabul0]);//yg awal
        $data1 = JagungAmatan::getDataByMultipleField(['tabul' => $tabul1]);//yang baru
        $jenis_subsegmen = ['a1', 'a2', 'b1', 'b2'];

        //validasi
        if(!$data1->isEmpty() && !$data0->isEmpty()){

            $uniqueKodeKabkota = $data1->pluck('kode_kabkota')->unique()->toArray();

            foreach ($uniqueKodeKabkota as $wil) {
                $filteredData1 = $data1->filter(function ($item) use ($wil) {
                    return $item['kode_kabkota'] === $wil;
                })->values();
                $filteredData0 = $data0->filter(function ($item) use ($wil) {
                    return $item['kode_kabkota'] === $wil;
                })->values();

                if(!$filteredData1->isEmpty() && !$filteredData0->isEmpty()){
                    $tmp = '';
                    $count_subsegmen = [];
                    $count_subsegmen['K'] = 0;
                    $count_subsegmen['TK'] = 0;
                    $count_subsegmen['W'] = 0;
                    $count_subsegmen['Total'] = 0;

                    $count_segmen = [];
                    $count_segmen['K'] = 0;
                    $count_segmen['TK'] = 0;
                    $evita = [];
                    $evita['A'] = 0;
                    $evita['R'] = 0;

                    $status = [];
                    $status['A'] = 0;
                    $status['R'] = 0;
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
                            $filteredData1[$i]['hasil_'.$jenis] = $this->validateJagung($filteredData0[$tmp][$jenis],$filteredData1[$i][$jenis]);
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

                        if($filteredData1[$i]['status'] == 'SUDAH LENGKAP'){
                            $status['A'] += 1;
                        }
                        if($count_seg == 0 && $filteredData1[$i]['status'] == 'SUDAH LENGKAP'){
                            $evita['A'] += 1;
                            $filteredData1[$i]['evita'] = 'APPROVED';
                        } else {
                            $evita['R'] += 1;
                            $filteredData1[$i]['evita'] = 'REJECTED';
                        }

                        $dataUpdate = array(
                            'hasil_a1' => $filteredData1[$i]['hasil_a1'],
                            'hasil_a2' => $filteredData1[$i]['hasil_a2'],
                            'hasil_b1' => $filteredData1[$i]['hasil_b1'],
                            'hasil_b2' => $filteredData1[$i]['hasil_b2'],
                            'evita' => $filteredData1[$i]['evita'],
                        );
                        JagungAmatan::where('indeks', $tabul1 . $filteredData1[$i]['kode_segmen'])->first()->update($dataUpdate);
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

                    $cekVal = JagungValidasi::getDataByIndeks($tabul1.$wil)->first();
                    if($cekVal){
                        $cekVal->update($dataVal);
                    } else {
                        JagungValidasi::create($dataVal);
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


    function validateJagung($x,$y){
        $hasil = '';
        switch($y){
            case 0:
                $hasil = 'TK';
                break;
            case 1:
                if($x == 0 || $x == 10){
                    $hasil = 'TK';
                } else {
                    $hasil = 'K';
                }
                break;
            case 2:
                if($x == 0 || $x == 3 || $x == 11){
                    $hasil = 'TK';
                } else {
                    $hasil = 'K';
                }
                break;
            case 3:
                if($x == 1 || $x == 2 || $x == 3){
                    $hasil = 'K';
                } else {
                    $hasil = 'TK';
                }
                break;
            case 4:
                if($x == 2 || $x == 3 || $x == 4){
                    $hasil = 'K';
                } else {
                    $hasil = 'TK';
                }
                break;
            case 5:
                if($x == 1 || $x == 2 || $x == 3 || $x == 5){
                    $hasil = 'K';
                } else{
                    $hasil = 'TK';
                }
                break;
            case 6:
                if($x == 2 || $x == 3 || $x == 4 || $x == 6){
                    $hasil = 'K';
                } else{
                    $hasil = 'TK';
                }
                break;
            case 7:
                if($x == 3 || $x == 4 || $x == 7){
                    $hasil = 'K';
                } else {
                    $hasil = 'TK';
                }
                break;
            case 8:
                if($x == 0 || $x == 10){
                    $hasil = 'TK';
                } else {
                    $hasil = 'K';
                }
                break;
            case 9:
                if($x == 0 || $x == 10){
                    $hasil = 'TK';
                } else {
                    $hasil = 'K';
                }
                break;
            case 10:
                if($x == 0 || $x == 11 || $x==9){
                    $hasil = 'TK';
                } else {
                    $hasil = 'K';
                }
                break;
            case 11:
                if($x == 1 || $x == 2 || $x == 3 || $x == 4 || $x == 11){
                    $hasil = 'K';
                } else {
                    $hasil = 'TK';
                }
                break;
        }
        return $hasil;
    }

    public function testPeta(){
        return view('jagung.test-peta');
    }

    public function getDataPeta(Request $request) {
        $tahun = $request->input('tahun_peta');
        $bulan = $request->input('bulan_peta');
        $geodata = $request->input('geodata');
        $geodata = json_decode($geodata,true);

        $wil = Auth::user()->kode;
        if ($wil != '3300') {
            return 'No Akses';
        }

        $data = JagungValidasi::where('indeks', 'like', $tahun . $bulan . "%")
                            ->get(['indeks', 'subsegmen_TK']);

        if ($data) {
            foreach ($geodata['features'] as $key => $feature) {
                foreach ($data as $datum) {
                    if ($feature['properties']['IDKAB'] == substr($datum->indeks,6,4)) {
                        // if($datum->indeks == '2024083321') dd($datum->subsegmen_TK);
                        $geodata['features'][$key]['properties']['KONSISTEN_P'] = $datum->subsegmen_TK;
                    }
                }
            }
        } else {
            foreach ($geodata['features'] as $key => $feature) {
                $geodata['features'][$key]['properties']['KONSISTEN_P'] = 'Tidak ada data';
            }
        }

        return json_encode($geodata);
    }

    public function getDataPetaSebaran(Request $request) {
        $tahun = $request->input('tahun_peta');
        $bulan = $request->input('bulan_peta');
        $fase = $request->input('fase');
        $geodata = $request->input('geodata');
        $geodata = json_decode($geodata,true);

        $wil = Auth::user()->kode;
        if ($wil != '3300') {
            return 'No Akses';
        }

        $data = JagungAmatan::countFase($tahun . $bulan, $fase);

        // dd(substr($data[0]->indeks,6,4), $data[0]->indeks);
        if ($data) {
            foreach ($geodata['features'] as $key => $feature) {
                foreach ($data as $datum) {
                    if ($feature['properties']['IDKAB'] == $datum->kode_kabkota) {
                        // if($datum->indeks == '2024083321') dd($datum->subsegmen_TK);
                        $geodata['features'][$key]['properties']['KONSISTEN_P'] = $datum->total_semua;
                    }
                }
            }
        } else {
            foreach ($geodata['features'] as $key => $feature) {
                $geodata['features'][$key]['properties']['KONSISTEN_P'] = 'Tidak ada data';
            }
        }

        return json_encode($geodata);
    }

    public function getDataProgres(Request $request) {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        $jenis = $request->input('jenis');
        $get = [];

        // dd($tahun, $bulan, $jenis);
        if($jenis == 'subsegmen'){
            $get[] = $jenis . '_K';
            $get[] = $jenis . '_W';
            $get[] = $jenis . '_TK';
        } else if ($jenis == 'segmen'){
            $get[] = $jenis . '_K';
            $get[] = $jenis . '_TK';
        } else {
            $get[] = $jenis . '_A';
            $get[] = $jenis . '_R';
        }

        $data = JagungValidasi::where('indeks', 'like', $tahun . $bulan . "%")
                            ->get(['indeks', ...$get]);

        $allKabKota = User::getAllKabKotaWithKeys();
        $dataWithKeys = $data->mapWithKeys(function ($item) use ($get) {
                                // Ambil nilai indeks
                                $indeks = $item->indeks;

                                // Ambil hanya kolom yang diinginkan dari $get
                                $values = collect($item)->only($get)->toArray();

                                // Ubah pasangan key-value menjadi array yang hanya berisi nilai
                                $values = array_values($values);

                                // Return format [indeks => [get1, get2, get3]]
                                return [substr(strval($indeks), 6, 4) => $values];
                            })
                            ->toArray();

        // dd($dataWithKeys, $allKabKota);

        // Ambil semua kunci dari $a dan $b
        $allKeys = array_unique(array_merge(array_keys($allKabKota), array_keys($dataWithKeys)));
        // dd($allKeys);

        foreach ($allKeys as $value) {
            if(in_array($value, array_keys($allKabKota))) {
                $allKabKota_modif[$value] = $allKabKota[$value];
            } else {
                $allKabKota_modif[$value] = 0;
            }
        }
        foreach ($allKeys as $value) {
            if(in_array($value, array_keys($dataWithKeys))) {
                $dataWithKeys_modif[$value] = $dataWithKeys[$value];
            } else {
                $dataWithKeys_modif[$value] = ($jenis == 'subsegmen') ? [0,0,0] : [0,0];
            }
        }
        // dd($allKeys, $dataWithKeys_modif);

        // Urutkan array berdasarkan key
        ksort($allKabKota_modif);
        ksort($dataWithKeys_modif);

        // Ambil hanya nilai dari array yang telah diurutkan
        $sortedAllKabKota = array_values($allKabKota_modif);
        $sortedData = array_values($dataWithKeys_modif);

        // dd($sortedData, $sortedAllKabKota);
        return response()->json([
            'labels' => $sortedAllKabKota,
            'rawData' => $sortedData,
        ]);
    }

    public function getDataCapaian(Request $request)
    {
        $jenisCapaian = $request->input('jenis_capaian');

        $wilayahCapaian = Auth::user()->kode;
        if ($wilayahCapaian == '3300') {
            $wilayahCapaian = $request->input('wilayah_capaian');
        }

        // Validasi input
        if (is_null($jenisCapaian) || is_null($wilayahCapaian)) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        // Ambil data berdasarkan jenis capaian dan wilayah
        $data1 = $this->fetchDataForChart1($jenisCapaian, $wilayahCapaian);
        $data2 = $this->fetchDataForChart2($jenisCapaian, $wilayahCapaian);

        return response()->json([
            'chart1' => $data1,
            'chart2' => $data2
        ]);
    }

/**
     * Mengambil data untuk chart.
     *
     * @param  string  $jenisCapaian
     * @param  string  $wilayahCapaian
     * @return array
     */
    private function fetchDataForChart1($jenisCapaian, $wilayahCapaian){

        $tahun = Carbon::now()->year;
        $kode_kabkota = $wilayahCapaian;
        if ($kode_kabkota == '3300') $kode_kabkota = '';
        $jenis = $jenisCapaian;
        $get = [];

        if($jenis == 'subsegmen'){
            $get[] = $jenis . '_K';
            $get[] = $jenis . '_W';
            $get[] = $jenis . '_TK';
        } else if ($jenis == 'segmen'){
            $get[] = $jenis . '_K';
            $get[] = $jenis . '_TK';
        } else {
            $get[] = $jenis . '_A';
            $get[] = $jenis . '_R';
        }

        // Mengambil data dengan tahun dan bulan terbesar
        $data = JagungValidasi::where('indeks', 'like', $tahun . "%")
            ->where('indeks', 'like', "%" . $kode_kabkota)
            ->get(['indeks', ...$get])->first();

        // Jika data ditemukan
        if ($data) {
            if($jenis == 'subsegmen'){
                return [
                    'labels' => ['Konsisten', 'Warning', 'Inkonsisten'],
                    'data' => [
                        $data->subsegmen_K ?? 0,
                        $data->subsegmen_W ?? 0,
                        $data->subsegmen_TK ?? 0
                    ]
                ];
            } else if ($jenis == 'segmen'){
                return [
                    'labels' => ['Konsisten', 'Inkonsisten'],
                    'data' => [
                        $data->segmen_K ?? 0,
                        $data->segmen_TK ?? 0
                    ]
                ];
            } else {
                return [
                    'labels' => ['Approved', 'Rejected'],
                    'data' => [
                        $data->evita_A ?? 0,
                        $data->evita_R ?? 0
                    ]
                ];
            }
        } else {
            if($jenis == 'subsegmen'){
                return [
                    'labels' => ['Konsisten', 'Warning', 'Inkonsisten'],
                    'data' => [0,0,0]
                ];
            } else if ($jenis == 'segmen'){
                return [
                    'labels' => ['Konsisten', 'Inkonsisten'],
                    'data' => [0,0]
                ];
            } else {
                return [
                    'labels' => ['Approved', 'Rejected'],
                    'data' => [0,0]
                ];
            }
        }
    }
    /**
         * Mengambil data untuk chart.
         *
         * @param  string  $jenisCapaian
         * @param  string  $wilayahCapaian
         * @return array
         */
    private function fetchDataForChart2($jenisCapaian, $wilayahCapaian){
        $tahun = Carbon::now()->year;
        $kode_kabkota = $wilayahCapaian;
        if ($kode_kabkota == '3300') $kode_kabkota = '';
        $jenis = $jenisCapaian;
        $get = [];

        if($jenis == 'subsegmen'){
            $get[] = $jenis . '_K';
            $get[] = $jenis . '_TK';
            $get[] = $jenis . '_W';
            // Mengambil data dengan tahun dan bulan terbesar
            $data = JagungValidasi::select(
                DB::raw('SUM('.$get[0].') as total_count0'),
                DB::raw('SUM('.$get[1].') as total_count1'),
                DB::raw('SUM('.$get[2].') as total_count2'),
            )
            ->where('indeks', 'like', $tahun . "%")
            ->where('indeks', 'like', "%" . $kode_kabkota)
            ->first();
        } else if ($jenis == 'segmen'){
            $get[] = $jenis . '_K';
            $get[] = $jenis . '_TK';
            // Mengambil data dengan tahun dan bulan terbesar
            $data = JagungValidasi::select(
                DB::raw('SUM('.$get[0].') as total_count0'),
                DB::raw('SUM('.$get[1].') as total_count1'),
            )
            ->where('indeks', 'like', $tahun . "%")
            ->where('indeks', 'like', "%" . $kode_kabkota)
            ->first();
        } else {
            $get[] = $jenis . '_A';
            $get[] = $jenis . '_R';
            // Mengambil data dengan tahun dan bulan terbesar
            $data = JagungValidasi::select(
                DB::raw('SUM('.$get[0].') as total_count0'),
                DB::raw('SUM('.$get[1].') as total_count1'),
            )
            ->where('indeks', 'like', $tahun . "%")
            ->where('indeks', 'like', "%" . $kode_kabkota)
            ->first();
        }

        // Jika data ditemukan
        if ($data) {
            if($jenis == 'subsegmen'){
                return [
                    'labels' => ['Konsisten', 'Warning', 'Inkonsisten'],
                    'data' => [
                        $data->total_count0 ?? 0,
                        $data->total_count1 ?? 0,
                        $data->total_count2 ?? 0
                    ]
                ];
            } else if ($jenis == 'segmen'){
                return [
                    'labels' => ['Konsisten', 'Inkonsisten'],
                    'data' => [
                        $data->total_count0 ?? 0,
                        $data->total_count1 ?? 0
                    ]
                ];
            } else {
                return [
                    'labels' => ['Approved', 'Rejected'],
                    'data' => [
                        $data->total_count0 ?? 0,
                        $data->total_count1 ?? 0
                    ]
                ];
            }
        } else {
            if($jenis == 'subsegmen'){
                return [
                    'labels' => ['Konsisten', 'Warning', 'Inkonsisten'],
                    'data' => [0,0,0]
                ];
            } else if ($jenis == 'segmen'){
                return [
                    'labels' => ['Konsisten', 'Inkonsisten'],
                    'data' => [0,0]
                ];
            } else {
                return [
                    'labels' => ['Approved', 'Rejected'],
                    'data' => [0,0]
                ];
            }
        }
    }
}
