<?php

namespace App\Services;

class ResponsesApi {

    public static function success($msg){
     return response()->json(
        [
            'status'=>true,
            'message'=>$msg
        ],200
    );
    }

    public static function error($msg,$code){
       return response()->json(
        [
            'status'=>false,
            'message'=>$msg
        ],$code
    );
    }

    public static function data($msg,$key,$data){
        return response()->json(
            [
                'status'=>true,
                $key=>$data
            ],200
        );
    }

}
