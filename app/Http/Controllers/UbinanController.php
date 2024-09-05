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
        return view("ubinan.lacak");
    }
    public function showPotensial(){
        return view("ubinan.potensial");
    }
    public function showUnggah(){
        // Ambil tahun terkecil dari database
        $minYear = Ubinan::min('tahun') ?? Carbon::now()->year;

        // Tahun sekarang
        $currentYear = Carbon::now()->addHours(7)->year;

        return view("ubinan.unggah",  [
            'minYear' => $minYear-1,
            'currentYear' => $currentYear,
        ]);
    }
    public function showRiwayat(){
        $allKabKota = User::getAllKabKota();
        $data = DB::table('ubinans')
            ->join('users', 'ubinans.kode_kabkota', '=', 'users.kode')
            ->selectRaw('CONCAT(ubinans.kode_kabkota, " - ", users.nama) as kab_kota, ubinans.kode_kabkota as kode_kabkota, ubinans.tahun, ubinans.bulan, COUNT(*) as baris, MAX(ubinans.updated_at) as last_update')
            ->groupBy('ubinans.kode_kabkota', 'ubinans.tahun', 'ubinans.bulan', 'users.nama')
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
                        'bln' => $row[$headerIndexes['frame_ksa']],
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
                    return redirect()->back()->with('success', 'Data jagung ' . $tabul . ' berhasil diunggah.')->withInput();
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
}
