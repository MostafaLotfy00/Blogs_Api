<?php

namespace App\Http\Controllers\Api;


use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $req){
        $validator= Validator::make($req->all(),[
            'name' => ['string','required','max:255'],
            'email'=> ['required','email', 'unique:'. User::class],
            'password' =>['required', 'confirmed', Rules\Password::defaults()]
        ],[],[
            'name'=> "Name",
            'email' => 'Email',
            'password' => 'Password'
        ]);

        if($validator->fails()){
            return ApiResponse::sendResponse(422, "Register Validation error", $validator->messages()->all());
        }

        $user= User::create([
            'name'=> $req->name,
            'email'=>strtolower($req->email),
            'password' => Hash::make($req->password)
        ]);
        $data['token']= $user->createToken('blog')->plainTextToken;
        $data['name']= $user->name;
        $data['email']= $user->email;
        return ApiResponse::sendResponse(201, "You Registered Successfully",$data);
    }

    public function login(Request $req){

        $validator= Validator::make($req->all(),[
            'email' => ['email', 'required'],
            'password' => 'required'
        ],[],[
            'email'=> 'Email',
            'password'=> 'Password'
        ]);

        if($validator->fails()){
            return ApiResponse::sendResponse(422, 'Login Validation error',$validator->messages()->all());
        }

        if(!Auth::attempt(['email'=>$req->email, 'password'=> $req->password])){
            return ApiResponse::sendResponse(401,"Invalid Email or Password",null);
        }

        $currentUser= User::find(Auth::user()->id);
        $data['token']= $currentUser->createToken('blog')->plainTextToken;
        $data['name']= $currentUser->name;
        $data['email']= $currentUser->email;
        return ApiResponse::sendResponse(200, 'logged in successfully',$data);
    }

    public function logout(Request $req){

        $success= $req->user()->currentAccessToken()->delete();
        if($success) return ApiResponse::sendResponse(200, 'You Logged out successfully',null);
    }
}
