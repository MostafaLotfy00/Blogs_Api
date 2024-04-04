<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\SubscribeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
# AUTH MODULE
Route::controller(AuthController::class)->group(function(){
    Route::post('/register','register');
    Route::post('/login','login');
    Route::post('/logout','logout')->middleware('auth:sanctum');
});
# USER MODULE
Route::get('/users/{user_id?}',[UserController::class,'getAll']);
# SUBSCRIBE MODULE
Route::controller(SubscribeController::class)->group(function(){
    Route::post('/subscribe','create');
});
# Contact MODULE
Route::controller(ContactController::class)->group(function(){
    Route::post('/contact','create');
});
# CATEGORY MODULE
Route::controller(CategoryController::class)->group(function(){
    Route::get('/categories','getCategories');
});

# BLOG MODULE
Route::controller(BlogController::class)->group(function(){
    Route::post('/blog','create')->middleware('auth:sanctum');
    Route::get('/blogs/{blog_id?}','getAll');
    
});

# COMMENT MODULE
Route::controller(CommentController::class)->group(function(){
 Route::post('comment', 'create')->middleware('auth:sanctum');
 Route::get('comments/{blog_id}', 'getAll');
});


