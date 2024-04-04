<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function create(Request $req){
        $validator= Validator::make($req->all(),[
            'subject' => 'string|required',
            'message' => 'string|required',
            'blog_id' => 'required|exists:blogs,id',
        ],[],[]);

        if($validator->fails())
         return ApiResponse::sendResponse(422, 'Validation error', $validator->messages()->all());

         $req['user_id']= $req->user()->id;

         $comment= Comment::create($req->all());
         if($comment)
         return ApiResponse::sendResponse(201,'Comment Created Successfully', new CommentResource($comment));
    }

    public function getAll($blog_id){
        $comments= Comment::where('blog_id', $blog_id)->latest()->get();
        if(count($comments) == 0){
            return ApiResponse::sendResponse(200, 'No avialable comments', []);
        }
        return ApiResponse::sendResponse(200, 'Comments retrieved successfully', CommentResource::collection($comments));
    }
}
