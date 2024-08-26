<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadPadiAmatanRequest;
use App\Imports\PadiAmatanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Models\PadiAmatan;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

    // public function uploadExcel(Request $request)
    // {
    //     $import = new PadiAmatanImport();

    //     try {
    //         Excel::import($import, $request->file('file'));

    //         if (session('error')) {
    //             return redirect()->back()->with('error', session('error'));
    //         }

    //         return redirect()->back()->with('success', 'File berhasil diunggah dan data telah dimasukkan.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'File Excel tidak valid atau kolom tidak sesuai.');
    //     }
    // }

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

        return redirect()->back()->with('success', 'Data berhasil diunggah.');
    }

}
