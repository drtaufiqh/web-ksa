<?php

namespace App\Imports;

use App\Models\PadiAmatan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Session;

HeadingRowFormatter::default('none');

class PadiAmatanImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PadiAmatan([
            'indeks' => $row['indeks'],
            'tabul' => $row['tabul'],
            'tahun' => $row['tahun'],
            'bulan' => $row['bulan'],
            'kode_segmen' => $row['kode_segmen'],
            'pcs' => $row['pcs'],
            'a1' => $row['a1'],
            'a2' => $row['a2'],
            'a3' => $row['a3'],
            'b1' => $row['b1'],
            'b2' => $row['b2'],
            'b3' => $row['b3'],
            'c1' => $row['c1'],
            'c2' => $row['c2'],
            'c3' => $row['c3'],
            'status' => $row['status'],
            // Kolom created_at dan akun akan diisi secara otomatis atau diabaikan
        ]);
    }

    public function rules(): array
    {
        return [
            '*.indeks' => 'required',
            '*.tabul' => 'required',
            '*.tahun' => 'required',
            '*.bulan' => 'required',
            '*.kode_segmen' => 'required',
            '*.pcs' => 'required',
            '*.a1' => 'required',
            '*.a2' => 'required',
            '*.a3' => 'required',
            '*.b1' => 'required',
            '*.b2' => 'required',
            '*.b3' => 'required',
            '*.c1' => 'required',
            '*.c2' => 'required',
            '*.c3' => 'required',
            '*.status' => 'required',
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function onFailure(Failure ...$failures)
    {
        $errors = [];

        foreach ($failures as $failure) {
            $errors[] = "Kesalahan pada baris " . $failure->row() . ": " . implode(', ', $failure->errors());
        }

        Session::flash('error', implode('<br>', $errors));
    }

    public function validateHeaders(array $header)
    {
        $requiredHeaders = ['indeks', 'tabul', 'tahun', 'bulan', 'kode_segmen', 'pcs', 'a1', 'a2', 'a3', 'b1', 'b2', 'b3', 'c1', 'c2', 'c3', 'status'];

        if (array_diff($requiredHeaders, $header)) {
            return false;
        }

        return true;
    }
}
