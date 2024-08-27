<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PadiValidasi extends Model
{
    use HasFactory;
    
    public static function getDataByIndeks($value)
    {
        return self::where('indeks', $value);
    }
}