<?php

namespace App\Http\Controllers;

use App\Models\Petani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetaniController extends Controller
{
    //
    public function getBySubsegmen($segmen, $sub){
        $wil = Auth::user()->kode;
        if ($wil != '3300' && $wil != substr($segmen,0,4)){
            $message = array(
                'status' => false,
                'segmen' => $segmen,
                'sub' => $sub
            );
            echo json_encode($message);
        }
        $data = Petani::fetchBySubsegmen($segmen,$sub);
        if(count($data)>0){
            $message = array(
                'status' => true,
                'data' => $data
            );
        } else {
            $message = array(
                'status' => false,
                'segmen' => $segmen,
                'sub' => $sub
            );
        }
        // dd($message);
        echo json_encode($message);
    }

    public function insertPetani(Request $request){
        $kode_segmen = $request->input('kode_segmen');
        $subsegmen = $request->input('subsegmen');
        $nik = $request->input('nik');
        $nama = $request->input('nama');
        $alamat = $request->input('alamat');
        $hp = $request->input('hp');
        $tanggal = $request->input('tanggal');

        $wil = Auth::user()->kode;
        if ($wil != '3300' && $wil != substr($kode_segmen,0,4)){
            $message = array(
                'status' => false,
                'message' => 'Tidak bisa insert kabupaten sebelah.',
            );
            return json_encode($message);
        }

        $newData = array(
            'kode_segmen' => $kode_segmen,
            'subsegmen' => $subsegmen,
            'nik' => $nik,
            'nama' => $nama,
            'alamat' => $alamat,
            'hp' => $hp,
            'tanggal' => $tanggal,
            'status' => 1,
            'last_update' => date("Y-m-d H:i:s"),
            'akun' => Auth::user()->email
        );

        // Cek apakah data sudah ada berdasarkan kode_segmen dan subsegmen
        $cekData = Petani::where('kode_segmen', $kode_segmen)
                         ->where('subsegmen', $subsegmen)
                         ->first();

        if (empty($cekData)) {
            // Jika data tidak ditemukan, insert data baru
            $q = Petani::create($newData);
        } else {
            // Jika data ditemukan, update data yang ada
            $q = $cekData->update($newData);
        }

        $message = array(
            'status' => true,
            'message' => 'Proses berhasil',
        );
        return json_encode($message);
    }

    public function deletePetani(Request $request){
        $id = $request->input('id');
        $kode_segmen = $request->input('kode_segmen');
        $subsegmen = $request->input('subsegmen');

        if (empty($id)) {
            // Fetch data by subsegmen
            $cekData = Petani::where('kode_segmen', $kode_segmen)
                              ->where('subsegmen', $subsegmen)
                              ->first();

            if ($cekData) {
                // Delete by ID from fetched data
                $cekData->delete();
                $response = ['message' => 'Data successfully deleted'];
            } else {
                $response = ['message' => 'No data found to delete'];
            }
        } else {
            // Delete by ID
            $petani = Petani::find($id);

            if ($petani) {
                $petani->delete();
                $response = ['message' => 'Data successfully deleted'];
            } else {
                $response = ['message' => 'No data found to delete'];
            }
        }

        $message = array(
            'status' => true,
            'message' => 'Proses penghapusan berhasil'
        );

        return json_encode($message);
    }

    public function getAll()
    {
        $wil = Auth::user()->kode;
        if ($wil == '3300') $wil = '33';
        $data = Petani::where('kode_segmen', 'like', $wil . '%')->get(); // Mengambil semua data dari model Petani

        // dd($data);

        if ($data->count() > 0) {
            $message = [
                'status' => true,
                'data' => $data
            ];
        } else {
            $message = [
                'status' => false,
                'message' => 'Data petani belum ada'
            ];
        }

        return response()->json($message);
    }
}
