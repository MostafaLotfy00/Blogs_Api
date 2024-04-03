<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getCategories(){
       $categories= Category::get();
       if(count($categories) == 0)
       return ApiResponse::sendResponse(200,"No available Categories", null);

       return ApiResponse::sendResponse(200,"Categories retrieved successfully", CategoryResource::collection($categories));

    }
}
