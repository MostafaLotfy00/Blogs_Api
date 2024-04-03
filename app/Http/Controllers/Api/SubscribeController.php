<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscribeController extends Controller
{
    public function create(Request $req){
       $validator= Validator::make($req->all(),[
        'email'=> 'required|email'
       ],[],[]);

       if($validator->fails()){
        return ApiResponse::sendResponse(422,'Subscribtion Failed', $validator->messages()->all());
       }
      $created= Subscribe::create(['email'=> $req->email]);
      if($created) return ApiResponse::sendResponse(201, "Subscribtion Created successfully",[]);
    }
}
