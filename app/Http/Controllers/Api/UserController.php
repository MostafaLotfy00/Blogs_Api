<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function getAll($user_id= null){
        if($user_id == null){
        $users= User::latest()->get();
        if(count($users) == 0){
            return ApiResponse::sendResponse(200, 'No Availble Blogs',[]);
        }
        return ApiResponse::sendResponse(200, 'Users retrieved successfully', UserResource::collection($users));
    }else{
        $user= User::find($user_id);
        if(!$user){
            return ApiResponse::sendResponse(200, 'No user with given id',[]);
        }
        return ApiResponse::sendResponse(200, 'user retrieved successfully',new UserResource($user));
    }
    }
}
