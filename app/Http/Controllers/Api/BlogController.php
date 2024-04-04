<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function create(Request $req){
        $validator= Validator::make($req->all(),[
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id'
        ],[],[]);
        if($validator->fails()){
            return ApiResponse::sendResponse(422, 'Validation error',$validator->messages()->all());
        }
        $data= $req->all();
        # Store Image
        $image= $req->image;
        $newImageName= time() . '-' . $image->getClientOriginalName();
        $image->storeAs('blogs',$newImageName, 'public');
        $data['image']= $newImageName;
        $data['user_id']= $req->user()->id;

        $blog= Blog::create($data);
        if($blog){
            return ApiResponse::sendResponse(201, 'Blog Created Successfully',new BlogResource($blog));
        }
    }

    public function getALl($blog_id= null){
        if($blog_id == null){
        $blogs= Blog::latest()->get();
        if(count($blogs) == 0){
            return ApiResponse::sendResponse(200, 'No Availble Blogs',[]);
        }
        return ApiResponse::sendResponse(200, 'Blogs retrieved successfully', BlogResource::collection($blogs));
    }else{
        $blog= Blog::find($blog_id);
        if(!$blog){
            return ApiResponse::sendResponse(200, 'No Blog with given id',[]);
        }
        return ApiResponse::sendResponse(200, 'Blog retrieved successfully',new BlogResource($blog));
    }
    }
}
