<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UbinanController extends Controller
{
    //
    public function showLacak(){
        return view("ubinan.lacak");
    }
    public function showPotensial(){
        return view("ubinan.potensial");
    }
    public function showUnggah(){
        return view("ubinan.unggah");
    }
    public function showRiwayat(){
        return view("ubinan.riwayat");
    }
}
