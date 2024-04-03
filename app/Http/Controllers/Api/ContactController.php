<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function create(Request $req){
        $validator= Validator::make($req->all(),[
            'name' => 'string|required|max:30',
            'email' =>'email|required',
            'subject' => 'string|required',
            'message' => 'string|required'
        ],[],[]);

        if($validator->fails())
         return ApiResponse::sendResponse(422, 'Validation error', $validator->messages()->all());

         $contact= Contact::create($req->all());
         if($contact)
         return ApiResponse::sendResponse(201,'Contact Created successfully',new ContactResource($contact));
    }
}
