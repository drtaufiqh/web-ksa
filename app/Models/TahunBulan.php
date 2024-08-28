<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunBulan extends Model
{
    use HasFactory;

    public static function getTabulSebelum($tabul){
        $tahun = substr($tabul, 0, 4);
        $bulan = substr($tabul, 4, 2);
        if ($bulan == '01'){
            $tabul_sebelum = ($tahun - 1) . '12';
        } else if (intval($bulan) <= 10) {
            $tabul_sebelum = $tahun . '0' . (intval($bulan) - 1);
        } else {
            $tabul_sebelum = $tahun . (intval($bulan) - 1);
        }

        return $tabul_sebelum;
    }
}