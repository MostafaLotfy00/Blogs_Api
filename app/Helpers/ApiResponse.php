<?php

namespace App\Helpers;

class ApiResponse{

    static function sendResponse($code = 200, $message = null, $data= null){
        $response=[
            'status'=> $code,
            'message'=> $message,
            'length' => is_countable($data)? count($data):1,
            'data'=>$data
        ];

        return response()->json($response,$code);
    }
}