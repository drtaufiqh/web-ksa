<?php

namespace App\Http\Controllers;

use App\Models\Petani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetaniController extends Controller
{
    //
    public function getBySubsegmen($segmen, $sub){
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

        $newData = array(
            'kode_segmen' => $kode_segmen,
            'subsegmen' => $subsegmen,
            'nik' => $nik,
            'nama' => $nama,
            'alamat' => $alamat,
            'hp' => $hp,
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
}
