<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petani extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    
    public static function fetchBySubsegmen($kode_segmen, $subsegmen)
    {
        $data = self::where('kode_segmen', $kode_segmen)
                  ->where('subsegmen', $subsegmen)
                  ->get()
                  ->toArray();

        return $data;
    }

}
