<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JagungAmatan extends Model
{
    use HasFactory;
    // Tentukan nama tabel dengan prefix 'paktani_'
    protected $table = 'paktani_jagung_amatans';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public static function getDataByField($field, $value)
    {
        return self::where($field, $value)->get();
    }

    public static function getDataByIndeks($value)
    {
        return self::where('indeks', 'like', $value . '%')->get();
    }

    /**
     * Get data by matching multiple field values.
     *
     * @param array $conditions
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getDataByMultipleField(array $conditions)
    {
        $query = self::query();

        foreach ($conditions as $field => $value) {
            $query->where($field, 'like', $value);
        }

        return $query->get();
    }
    public static function countFase($tabul, $fase){
        // Menggunakan query builder untuk menghitung banyaknya record
        // dari a1, a2, a3, lalu group by 'kode_kabkota'
        return self::select('kode_kabkota', \DB::raw('
                    (
                        SUM(CASE WHEN a1 = '.$fase.' THEN 1 ELSE 0 END) +
                        SUM(CASE WHEN a2 = '.$fase.' THEN 1 ELSE 0 END) +
                        SUM(CASE WHEN b1 = '.$fase.' THEN 1 ELSE 0 END) +
                        SUM(CASE WHEN b2 = '.$fase.' THEN 1 ELSE 0 END)
                    ) as total_semua
                '))
                ->where('tabul', $tabul)
                ->groupBy('kode_kabkota')
                ->get();
    }
}
