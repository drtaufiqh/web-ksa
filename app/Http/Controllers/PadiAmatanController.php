<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadPadiAmatanRequest;
use App\Imports\PadiAmatanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Models\PadiAmatan;
use Illuminate\Support\Facades\Validator;

class PadiAmatanController extends Controller
{
    public function showUploadForm()
    {
        return view('padi.unggah');
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

        // Ambil nama file dan ambil 4 karakter pertama
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $tahun = substr($fileName, 0, 4);
        $bulan = substr($fileName, 4, 2);
        $tabul = substr($fileName, 0, 6);

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

        // // Proses data jika validasi sukses
        // foreach ($data[0] as $key => $row) {
        //     if ($key == 0) {
        //         continue; // Lewatkan header
        //     }

        //     // Buat array untuk mapping subsegmen ke kolom database
        //     $mapping = [
        //         'A1' => 'a1',
        //         'A2' => 'a2',
        //         'A3' => 'a3',
        //         'B1' => 'b1',
        //         'B2' => 'b2',
        //         'B3' => 'b3',
        //         'C1' => 'c1',
        //         'C2' => 'c2',
        //         'C3' => 'c3',
        //     ];

        //     if (isset($headerIndexes['id segmen'], $headerIndexes['nama'], $headerIndexes['subsegmen'], $headerIndexes['status'], $headerIndexes['amatan'])) {
        //         $indeks = $tabul . $row[$headerIndexes['id segmen']];
        //         $pcs = $row[$headerIndexes['nama']];
        //         $kode_segmen = $row[$headerIndexes['id segmen']];
        //         $status = $row[$headerIndexes['status']];
        //         $subsegmen = $row[$headerIndexes['subsegmen']];

        //         $amatan = $row[$headerIndexes['amatan']];
        //         $parts = explode('.', $amatan);
        //         $nValue = $parts[0];

        //         // Pemetaan subsegmen ke kolom database
        //         $mapping = [
        //             'A1' => 'a1',
        //             'A2' => 'a2',
        //             'A3' => 'a3',
        //             'B1' => 'b1',
        //             'B2' => 'b2',
        //             'B3' => 'b3',
        //             'C1' => 'c1',
        //             'C2' => 'c2',
        //             'C3' => 'c3',
        //         ];
    
        //         // Buat array dengan data yang akan diinput ke database
        //         $dataToInsert = [
        //             'indeks' => $indeks,
        //             'tabul' => $tabul,
        //             'tahun' => $tahun,
        //             'bulan' => $bulan,
        //             'kode_segmen' => $kode_segmen,
        //             'pcs' => $pcs,
        //             'status' => $status,
        //             $mapping[$subsegmen] => $nValue, // Isi kolom yang sesuai dengan subsegmen
        //         ];
        //         // dd($dataToInsert);
    
        //         // Periksa apakah entri dengan kode_segmen yang sama sudah ada
        //         $existingRecord = PadiAmatan::where('indeks', $indeks)->first();
    
        //         if ($existingRecord) {
        //             // Jika sudah ada, perbarui data
        //             $existingRecord->update($dataToInsert);
        //         } else {
        //             // Jika tidak ada, buat entri baru
        //             PadiAmatan::create($dataToInsert);
        //         }
        //     } else {
        //         // Tangani kasus jika kunci header tidak ada dalam data
        //         return back()->withErrors(['file' => 'Kolom yang diperlukan tidak ada dalam file Excel.'])->withInput();
        //     }
        // }
        // Array untuk menampung data yang akan dimasukkan ke database
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
                        'pcs' => $pcs,
                        'status' => $status,
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

        return redirect()->back()->with('success', 'Data berhasil diunggah.');
    }

}
