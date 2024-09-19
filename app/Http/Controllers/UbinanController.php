<?php

namespace App\Http\Controllers;

use App\Models\Ubinan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class UbinanController extends Controller
{
    //
    public function showLacak(){
        // Ambil tahun terkecil dari database
        $minYear = Ubinan::min('tahun') ?? Carbon::now()->year;

        // Tahun sekarang
        $currentYear = Carbon::now()->year;

        return view("ubinan.lacak",  [
            'minYear' => $minYear-1,
            'currentYear' => $currentYear,
        ]);
    }
    public function showPotensial(){
        // Ambil tahun terkecil dari database
        $minYear = Ubinan::min('tahun') ?? Carbon::now()->year;

        // Tahun sekarang
        $currentYear = Carbon::now()->year;

        return view("ubinan.potensial",  [
            'minYear' => $minYear-1,
            'currentYear' => $currentYear,
        ]);
    }
    public function showPanduan(){
        return view("ubinan.panduan");
    }
    public function showUnggah(){
        // Ambil tahun terkecil dari database
        $minYear = Ubinan::min('tahun') ?? Carbon::now()->year;

        // Tahun sekarang
        $currentYear = Carbon::now()->year;

        return view("ubinan.unggah",  [
            'minYear' => $minYear-1,
            'currentYear' => $currentYear,
        ]);
    }
    public function showKelola(){
        return view("ubinan.kelola");
    }
    public function showRiwayat(){
        $wil = Auth::user()->kode;
        if ($wil == '3300') $wil = '33';
        $allKabKota = User::getAllKabKota();
        $data = DB::table('paktani_ubinans')
            ->join('paktani_users', 'paktani_ubinans.kode_kabkota', '=', 'paktani_users.kode')
            ->selectRaw('CONCAT(paktani_ubinans.kode_kabkota, " - ", paktani_users.nama) as kab_kota, paktani_ubinans.kode_kabkota as kode_kabkota, paktani_ubinans.tahun, paktani_ubinans.bulan, COUNT(*) as baris, MAX(paktani_ubinans.updated_at) as last_update')
            ->groupBy('paktani_ubinans.kode_kabkota', 'paktani_ubinans.tahun', 'paktani_ubinans.bulan', 'paktani_users.nama')
            ->where('kode_kabkota', 'like', $wil . '%')
            ->get();
        return view("ubinan.riwayat", [
            'data' => $data,
            'allKabKota' => $allKabKota,
        ]);
    }

    public function import(Request $request){
        $error = 0;
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        $sampel = $request->input('sampel');
        $indeks = $tahun . $bulan;
        $tabul = $tahun.$bulan;

        $target_dir = "./file/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
		$uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // dd(strtolower(substr(basename($_FILES["file"]["name"]),0,7)), strtolower($tabul));
		if(strtolower(substr(basename($_FILES["file"]["name"]),0,7)) != strtolower($tabul . $sampel)){
            $message = array(
                'status' => false,
                'message' => 'Data tahun dan bulan tidak cocok'
            );
			$uploadOk = 0;
            return back()->withErrors(['file' => 'Data tahun, bulan, dan jenis sampel tidak cocok'])->withInput();
		}
        // Check file extension
        if ($fileType != 'xlsx') {
            $message = array(
                'status' => false,
                'message' => 'Tipe file harus .xlsx'
            );
            $uploadOk = 0;
            return back()->withErrors(['file' => 'Tipe file harus .xlsx'])->withInput();
        }
        // Check if file already exists
		// if (file_exists($target_file)) {
        //     unlink($target_file);
        //     $message = array(
        //         'status' => false,
        //         'message' => 'File dengan nama ini sudah ada'
        //     );
        //     return back()->withErrors(['file' => 'File dengan nama ini sudah ada'])->withInput();
		// }
		// Check file size
		if ($_FILES["file"]["size"] > 100000000) {
			$message = array(
                'status' => false,
                'message' => 'Ukuran file terlalu besar'
            );
            $uploadOk = 0;
            return back()->withErrors(['file' => 'Ukuran file terlalu besar'])->withInput();
		}
		if ($uploadOk == 1) {
            $data = [];
			if ($target_file) {
                $file = $request->file('file');
                // //read file from path
                // $objPHPExcel = PHPExcel_IOFactory::load($file);

                // //get only the Cell Collection
                // $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

                // Baca file excel
                $data = Excel::toArray([], $file);

                // Ambil header (baris pertama) dari file excel
                $header = array_map('trim', $data[0][0]);

                // Tentukan header minimal yang diharapkan
                $requiredHeader = [
                    'jenis_sampel', 'frame_ksa', 'nmprop', 'nmkab', 'nmkec', 'namalok', 'subsegmen', 'strata', 'fasetanam', 'nama_pcs', 'hp_pcs', 'nama_pms', 'hp_pms', 'nks', 'subround', 'idsegmen'
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
                    $kode_segmen = $row[$headerIndexes['idsegmen']];
                    $indeks = $tabul . $kode_segmen;
                    $kode_kabkota = substr($kode_segmen, 0, 4);

                    $groupedData[$indeks] = [
                        'indeks' => $indeks,
                        'tabul' => $tabul,
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                        'prov' => $row[$headerIndexes['nmprop']],
                        'kab' => $row[$headerIndexes['nmkab']],
                        'kec' => $row[$headerIndexes['nmkec']],
                        'lokasi' => $row[$headerIndexes['namalok']],
                        'kode_segmen' => $kode_segmen,
                        'kode_kabkota' => $kode_kabkota,
                        'subsegmen' => $row[$headerIndexes['subsegmen']],
                        'fase' => $row[$headerIndexes['fasetanam']],
                        'strata' => $row[$headerIndexes['strata']],
                        'nks' => $row[$headerIndexes['nks']],
                        'pcs' => $row[$headerIndexes['nama_pcs']],
                        'hp_pcs' => $row[$headerIndexes['hp_pcs']],
                        'pms' => $row[$headerIndexes['nama_pms']],
                        'hp_pms' => $row[$headerIndexes['hp_pms']],
                        'bln' => $row[$headerIndexes['bulan']],
                        'subround' => $row[$headerIndexes['subround']],
                        'jenis_sampel' => $row[$headerIndexes['jenis_sampel']],
                        'akun' => Auth::user()->email,
                    ];
                }

                // Masukkan data yang sudah digabung ke dalam database
                foreach ($groupedData as $dataToInsert) {
                    $kodekab = $dataToInsert['kode_kabkota'];
                    if (Auth::user()->role == 'prov' || Auth::user()->kode == $kodekab){
                        // Periksa apakah entri dengan kode_segmen yang sama sudah ada
                        $existingRecord = Ubinan::where('indeks', $dataToInsert['indeks'])->first();
                        if ($existingRecord) {
                            // Jika sudah ada, perbarui data
                            $existingRecord->update($dataToInsert);
                        } else {
                            // Jika tidak ada, buat entri baru
                            Ubinan::create($dataToInsert);
                        }
                    } else {
                        $error = 1;
                        break;
                    }
                }

                if($error == 0){
                    $message = array(
                        'status' => true,
                        // 'arr_data' => $arr_data,
                        'message' => 'Data berhasil diupload',
                    );
                    return redirect()->back()->with('success', 'Data padi sampel ubinan ' . $tabul . ' berhasil diunggah.')->withInput();
                } else {
                    $message = array(
                        'status' => false,
                        'message' => 'Data ditolak, tidak sesuai wilayah kerja',
                    );
                    return back()->withErrors(['file' => 'Data ditolak, tidak sesuai wilayah kerja'])->withInput();
                }
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Data gagal diupload',
                );
                return back()->withErrors(['file' => 'Data gagal diupload'])->withInput();
            }
        //     unlink($target_file);
        }
        // echo json_encode($message);
    }

    public function showDetail($id, $tahun, $bulan){
        $wil = Auth::user()->kode;
        if ($wil != '3300' && $wil != $id) {
            return 'No Akses' ;
        }
        // Ambil data detail dari database berdasarkan ID
        $data = Ubinan::where('kode_kabkota', $id)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->get(); // Sesuaikan dengan query Anda

        // Kirimkan data dalam format JSON
        return response()->json([
            'data' => $data
        ]);
    }

    public function proses(Request $request){
        $err = 0;
        $tabul = $request->input('tabul');
        $bulansampel = $request->input('bulansampel');
        $tahunsampel = $request->input('tahunsampel');

        $wil = Auth::user()->kode;
        if(Auth::user()->role=='prov'){
            $prov = substr($wil,0,2);
        } else {
            $prov = $wil;
        }
        switch($bulansampel){
            case 1:
                $tabul0 = $tahunsampel.'01';
                $tabul1 = $tahunsampel.'02';
                break;
            case 3:
                $tabul0 = $tahunsampel.'03';
                $tabul1 = $tahunsampel.'04';
                break;
            case 5:
                $tabul0 = $tahunsampel.'05';
                $tabul1 = $tahunsampel.'06';
                break;
            case 7:
                $tabul0 = $tahunsampel.'07';
                $tabul1 = $tahunsampel.'08';
                break;
            case 9:
                $tabul0 = $tahunsampel.'09';
                $tabul1 = $tahunsampel.'10';
                break;
            case 11:
                $tabul0 = $tahunsampel.'11';
                $tabul1 = $tahunsampel.'12';
                break;

            case 21:
                $tabul0 = $tahunsampel.'01';
                $tabul1 = $tahunsampel.'04';
                break;
            case 22:
                $tabul0 = $tahunsampel.'05';
                $tabul1 = $tahunsampel.'08';
                break;
            case 23:
                $tabul0 = $tahunsampel.'09';
                $tabul1 = $tahunsampel.'12';
                break;
        }

        if($err == 0){
            $dataSampel = Ubinan::getSampel($tabul0.$prov,$tabul1.$prov);
            $tabel = 'paktani_padi_amatans';
            $dataAmatan = Ubinan::getData($tabul.$prov,$tabel);

            $count = [];
            $count[0] = 0;
            $count[1] = 0;
            $count[2] = 0;
            $count[3] = 0;
            $count[4] = 0;
            $count[5] = 0;

            if(!empty($dataSampel) && !empty($dataAmatan) ){
                foreach($dataSampel as $s){
                    if(ISSET($dataAmatan[$s['kode_segmen']])){
                        $dataSampel[$s['kode_segmen'].$s['subsegmen']]['amatan'] = $dataAmatan[$s['kode_segmen']][strtolower($s['subsegmen'])];
                    } else {
                        $dataSampel[$s['kode_segmen'].$s['subsegmen']]['amatan'] = 0;
                    }
                    $dataSampel[$s['kode_segmen'].$s['subsegmen']]['color'] = $this->color($dataSampel[$s['kode_segmen'].$s['subsegmen']]['amatan']);
                    $dataSampel[$s['kode_segmen'].$s['subsegmen']]['keterangan'] = $this->status($dataSampel[$s['kode_segmen'].$s['subsegmen']]['amatan']);

                    if($dataSampel[$s['kode_segmen'].$s['subsegmen']]['keterangan'] == 'AVAILABLE'){
                        if($dataSampel[$s['kode_segmen'].$s['subsegmen']]['jenis_sampel'] == 'U'){
                            $count[0] += 1;
                        } else {
                            $count[3] += 1;
                        }
                    } else if($dataSampel[$s['kode_segmen'].$s['subsegmen']]['keterangan'] == 'UNAVAILABLE'){
                        if($dataSampel[$s['kode_segmen'].$s['subsegmen']]['jenis_sampel'] == 'U'){
                            $count[1] += 1;
                        } else {
                            $count[4] += 1;
                        }
                    } else if($dataSampel[$s['kode_segmen'].$s['subsegmen']]['keterangan'] == 'NON-ELIGIBLE'){
                        if($dataSampel[$s['kode_segmen'].$s['subsegmen']]['jenis_sampel'] == 'U'){
                            $count[2] += 1;
                        } else {
                            $count[5] += 1;
                        }
                    }

                }

                $message = array(
                    'status' => true,
                    'tabul0' => $tabul0,
                    'amatan' => $dataAmatan,
                    'sampel' => $dataSampel,
                    'count' => $count
                );
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Ada minimal salah satu sumber data belum diupload'
                );
            }
        }
        return json_encode($message);
    }

    function color($x){
        if($x==2 || $x==3){
            return '#abe96c';
        } else if($x==4){
            return '#ffc37c';
        } else {
            return '#ff5050';
        }
    }

    function status($x){
        if($x==2 || $x==3){
            return 'AVAILABLE';
        } else if($x==4){
            return 'UNAVAILABLE';
        } else {
            return 'NON-ELIGIBLE';
        }
    }

    public function cadangan(Request $request){
        $err = 0;
        $tabul = $request->input('tabul');
        $bulansampel = $request->input('bulansampel');
        $tahunsampel = $request->input('tahunsampel');

        $wil = Auth::user()->kode;
        if(Auth::user()->role=='prov'){
            $prov = substr($wil,0,2);
        } else {
            $prov = $wil;
        }
        // dd($bulansampel, $tahunsampel, $tabul);
        switch($bulansampel){
            case 1:
                $tabul0 = $tahunsampel.'01';
                $tabul1 = $tahunsampel.'02';
                break;
            case 3:
                $tabul0 = $tahunsampel.'03';
                $tabul1 = $tahunsampel.'04';
                $tabul2 = $tahunsampel.'01';
                $tabul3 = $tahunsampel.'02';
                break;
            case 5:
                $tabul0 = $tahunsampel.'05';
                $tabul1 = $tahunsampel.'06';
                break;
            case 7:
                $tabul0 = $tahunsampel.'07';
                $tabul1 = $tahunsampel.'08';
                $tabul2 = $tahunsampel.'05';
                $tabul3 = $tahunsampel.'06';
                break;
            case 9:
                $tabul0 = $tahunsampel.'09';
                $tabul1 = $tahunsampel.'10';
                break;
            case 11:
                $tabul0 = $tahunsampel.'11';
                $tabul1 = $tahunsampel.'12';
                $tabul2 = $tahunsampel.'09';
                $tabul3 = $tahunsampel.'10';
                break;
        }

        if($err == 0){
            if($bulansampel==1 || $bulansampel==5 || $bulansampel ==9){
                $dataSampel = Ubinan::getSampel($tabul0.$prov,$tabul1.$prov);
            } else {
                $dataSampel = Ubinan::getSampelSubround($tabul0.$prov,$tabul1.$prov,$tabul2.$prov,$tabul3.$prov);
            }
            $tabel = 'paktani_padi_amatans';
            $dataAmatan = Ubinan::getData($tabul.$prov,$tabel);

            $segmen = [];//segmen yang ada fase 2 dan 3
            $elig = [];//data yang eligible, diluar sampel
            $count = [];
            $count[0] = 0;
            $count[1] = 0;
            $count[2] = 0;
            $count[3] = 0;
            $count[4] = 0;

            if(!empty($dataSampel) && !empty($dataAmatan) ){
                //tambahin aja subsegmen ....
                $row = 0;
                foreach($dataAmatan as $a){
                    $subseg = 'x1';
                    if(ISSET($dataSampel[$a['kode_segmen']])){
                        $subseg = strtolower($dataSampel[$a['kode_segmen']]['subsegmen']);
                    }
                    if(($a['a1'] == 2 || $a['a1'] == 3) && !ISSET($dataSampel[$a['kode_segmen'].'A1'])){
                        $segmen[$row] = array(
                            'kode_segmen' => $a['kode_segmen'],
                            'subsegmen' => 'A1',
                            'amatan' => $a['a1'],
                            'kel' => $a['kel'],
                        );
                        $row++;
                    }
                    if(($a['a2'] == 2 || $a['a2'] == 3) && !ISSET($dataSampel[$a['kode_segmen'].'A2'])){
                        $segmen[$row] = array(
                            'kode_segmen' => $a['kode_segmen'],
                            'subsegmen' => 'A2',
                            'amatan' => $a['a2'],
                            'kel' => $a['kel'],
                        );
                        $row++;
                    }
                    if(($a['a3'] == 2 || $a['a3'] == 3) && !ISSET($dataSampel[$a['kode_segmen'].'A3'])){
                        $segmen[$row] = array(
                            'kode_segmen' => $a['kode_segmen'],
                            'subsegmen' => 'A3',
                            'amatan' => $a['a3'],
                            'kel' => $a['kel'],
                        );
                        $row++;
                    }
                    if(($a['b1'] == 2 || $a['b1'] == 3) && !ISSET($dataSampel[$a['kode_segmen'].'B1'])){
                        $segmen[$row] = array(
                            'kode_segmen' => $a['kode_segmen'],
                            'subsegmen' => 'B1',
                            'amatan' => $a['b1'],
                            'kel' => $a['kel'],
                        );
                        $row++;
                    }
                    if(($a['b2'] == 2 || $a['b2'] == 3) && !ISSET($dataSampel[$a['kode_segmen'].'B2'])){
                        $segmen[$row] = array(
                            'kode_segmen' => $a['kode_segmen'],
                            'subsegmen' => 'B2',
                            'amatan' => $a['b2'],
                            'kel' => $a['kel'],
                        );
                        $row++;
                    }
                    if(($a['b3'] == 2 || $a['b3'] == 3) && !ISSET($dataSampel[$a['kode_segmen'].'B3'])){
                        $segmen[$row] = array(
                            'kode_segmen' => $a['kode_segmen'],
                            'subsegmen' => 'B3',
                            'amatan' => $a['b3'],
                            'kel' => $a['kel'],
                        );
                        $row++;
                    }
                    if(($a['c1'] == 2 || $a['c1'] == 3) && !ISSET($dataSampel[$a['kode_segmen'].'C1'])){
                        $segmen[$row] = array(
                            'kode_segmen' => $a['kode_segmen'],
                            'subsegmen' => 'C1',
                            'amatan' => $a['c1'],
                            'kel' => $a['kel'],
                        );
                        $row++;
                    }
                    if(($a['c2'] == 2 || $a['c2'] == 3) && !ISSET($dataSampel[$a['kode_segmen'].'C2'])){
                        $segmen[$row] = array(
                            'kode_segmen' => $a['kode_segmen'],
                            'subsegmen' => 'C2',
                            'amatan' => $a['c2'],
                            'kel' => $a['kel'],
                        );
                        $row++;
                    }
                    if(($a['c3'] == 2 || $a['c3'] == 3) && !ISSET($dataSampel[$a['kode_segmen'].'C3'])){
                        $segmen[$row] = array(
                            'kode_segmen' => $a['kode_segmen'],
                            'subsegmen' => 'C3',
                            'amatan' => $a['c3'],
                            'kel' => $a['kel'],
                        );
                        $row++;
                    }
                }

                $message = array(
                    'status' => true,
                    'tabul0' => $tabul0,
                    'amatan' => $dataAmatan,
                    'sampel' => $dataSampel,
                    'segmen' => $segmen,
                    'count' => $count
                );
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'Ada minimal salah satu sumber data belum diupload'
                );
            }
        }
        return json_encode($message);
    }
}
