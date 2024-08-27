<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PadiAmatan extends Model
{
    use HasFactory;

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
}
