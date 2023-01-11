<?php

namespace App\Trait;

use Illuminate\Http\Response;

class CustomResponse {

    public static function success($data , $msg="Operation Success" , $code=200){
        return response()->json([
            "msg" => $msg,
            "data"=> $data
        ]
        , $code);
    }

    public static function failed($data = [] , $msg="Operation Failed" , $code=400){
        return response()->json([
            "msg" => $msg,
            "data"=> $data
        ]
        , $code);
    }
}
?>
