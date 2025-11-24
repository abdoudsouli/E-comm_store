<?php

namespace App\Helper;

class ResponsesApi {
 public static function success($message = '', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ], $code);
    }

    public static function data($data = null,$message=null, $key = 'data', $value = null, $code = 200)
    {
        if ($value === null) return response()->json(['success'=>true,'message'=>$message, 'data'=>$data], $code);
        return response()->json(['success'=>true,'message'=>$message, $key => $value], $code);
    }

    public static function error($message = 'Error', $code = 400)
    {
        return response()->json(['success'=>false, 'message'=>$message], $code);
    }

}
