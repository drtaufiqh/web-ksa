<?php

namespace App\Http\Controllers;

use App\Models\Petani;
use Illuminate\Http\Request;

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
}
