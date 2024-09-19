<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PadiValidasi extends Model
{
    use HasFactory;
    // Tentukan nama tabel dengan prefix 'paktani_'
    protected $table = 'paktani_padi_validasis';

    protected $guarded = [];

    public static function getDataByIndeks($value)
    {
        return self::where('indeks', 'like', $value);
    }
}
