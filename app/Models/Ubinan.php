<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ubinan extends Model
{
    use HasFactory;
    // Tentukan nama tabel dengan prefix 'paktani_'
    protected $table = 'paktani_ubinans';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public static function getSampel($indeks0, $indeks1) {
        // Mengambil data berdasarkan indeks0
        $data = self::where('indeks', 'like', "$indeks0%")
                ->get();

        $arr = [];

        // Mengisi array dengan hasil query dari indeks0
        foreach ($data as $row) {
            $key = $row->kode_segmen . $row->subsegmen;
            $arr[$key] = [
                'kode_segmen'  => $row->kode_segmen,
                'subsegmen'    => $row->subsegmen,
                'lokasi'       => $row->lokasi,
                'strata'       => $row->strata,
                'nks'          => $row->nks,
                'pcs'          => $row->pcs,
                'pms'          => $row->pms,
                'bln'          => $row->bln,
                'jenis_sampel' => $row->jenis_sampel
            ];
        }

        // Mengambil data berdasarkan indeks1
        $data1 = self::where('indeks', 'like', "$indeks1%")
                ->get();

        // Mengisi array dengan hasil query dari indeks1
        foreach ($data1 as $row) {
            $key = $row->kode_segmen . $row->subsegmen;
            $arr[$key] = [
                'kode_segmen'  => $row->kode_segmen,
                'subsegmen'    => $row->subsegmen,
                'lokasi'       => $row->lokasi,
                'strata'       => $row->strata,
                'nks'          => $row->nks,
                'pcs'          => $row->pcs,
                'pms'          => $row->pms,
                'bln'          => $row->bln,
                'jenis_sampel' => $row->jenis_sampel
            ];
        }

        return $arr;
    }

    public static function getSampelSubround($indeks0, $indeks1, $indeks2, $indeks3){
        $arr = [];

        // Fetch data based on 'indeks0'
        $data0 = Ubinan::where('indeks', 'like', $indeks0 . '%')->get();
        foreach ($data0 as $row) {
            $key = $row->kode_segmen . $row->subsegmen;
            $arr[$key] = [
                'kode_segmen' => $row->kode_segmen,
                'subsegmen' => $row->subsegmen,
                'lokasi' => $row->lokasi,
                'strata' => $row->strata,
                'nks' => $row->nks,
                'pcs' => $row->pcs,
                'pms' => $row->pms,
                'bln' => $row->bln,
                'jenis_sampel' => $row->jenis_sampel
            ];
        }

        // Fetch data based on 'indeks1'
        $data1 = Ubinan::where('indeks', 'like', $indeks1 . '%')->get();
        foreach ($data1 as $row) {
            $key = $row->kode_segmen . $row->subsegmen;
            $arr[$key] = [
                'kode_segmen' => $row->kode_segmen,
                'subsegmen' => $row->subsegmen,
                'lokasi' => $row->lokasi,
                'strata' => $row->strata,
                'nks' => $row->nks,
                'pcs' => $row->pcs,
                'pms' => $row->pms,
                'bln' => $row->bln,
                'jenis_sampel' => $row->jenis_sampel
            ];
        }

        // Fetch data based on 'indeks2'
        $data2 = Ubinan::where('indeks', 'like', $indeks2 . '%')->get();
        foreach ($data2 as $row) {
            $key = $row->kode_segmen . $row->subsegmen;
            $arr[$key] = [
                'kode_segmen' => $row->kode_segmen,
                'subsegmen' => $row->subsegmen,
                'lokasi' => $row->lokasi,
                'strata' => $row->strata,
                'nks' => $row->nks,
                'pcs' => $row->pcs,
                'pms' => $row->pms,
                'bln' => $row->bln,
                'jenis_sampel' => $row->jenis_sampel
            ];
        }

        // Fetch data based on 'indeks3'
        $data3 = Ubinan::where('indeks', 'like', $indeks3 . '%')->get();
        foreach ($data3 as $row) {
            $key = $row->kode_segmen . $row->subsegmen;
            $arr[$key] = [
                'kode_segmen' => $row->kode_segmen,
                'subsegmen' => $row->subsegmen,
                'lokasi' => $row->lokasi,
                'strata' => $row->strata,
                'nks' => $row->nks,
                'pcs' => $row->pcs,
                'pms' => $row->pms,
                'bln' => $row->bln,
                'jenis_sampel' => $row->jenis_sampel
            ];
        }

        return $arr;
    }

    public static function getData($indeks, $tabel) {
        // Mengambil data berdasarkan indeks
        $data = DB::table($tabel)
                ->where('indeks', 'like', "$indeks%")
                ->get();

        $arr = [];

        // Mengisi array dengan hasil query
        foreach ($data as $row) {
            $key = $row->kode_segmen;
            $arr[$key] = [
                'kode_segmen' => $row->kode_segmen,
                'kel'         => null, // Set nilai kel menjadi null
                'a1'          => $row->a1,
                'a2'          => $row->a2,
                'a3'          => $row->a3,
                'b1'          => $row->b1,
                'b2'          => $row->b2,
                'b3'          => $row->b3,
                'c1'          => $row->c1,
                'c2'          => $row->c2,
                'c3'          => $row->c3
            ];
        }

        return $arr;
    }

}
