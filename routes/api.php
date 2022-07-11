<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware'=>['api',/*'checkPassword',*/'changeLangue']],function(){
    Route::get('get_all_category','App\Http\Controllers\Api\CategoriesController@index');
    Route::get('get_category_change_lang','App\Http\Controllers\Api\CategoriesController@getCategoryAndChangeLang');

    Route::get('get_category_by_id','App\Http\Controllers\Api\CategoriesController@getCategoryById');
    Route::post('change_category_status','App\Http\Controllers\Api\CategoriesController@changeCategoryStatus');



    Route::group(['prefix' => 'admin'],function (){
        Route::post('login', 'App\Http\Controllers\Api\Admin\AuthController@login');
        Route::post('logout', 'App\Http\Controllers\Api\Admin\AuthController@logout')->middleware('auth.guard:admin-api');


      
    
});


Route::group(['prefix' => 'user'],function (){
    Route::post('login', 'App\Http\Controllers\Api\User\AuthController@login');
});




Route::group(['prefix'=>'user','middleware'=>'auth.guard:user-api'],function(){
    Route::post('profile',function(){
        return Auth::user();
    });
});
  

});



Route::group(['middleware'=>['api','checkPassword','changeLangue','checkAdminToken:admin-api']],function(){
    Route::get('get_all_category','App\Http\Controllers\Api\CategoriesController@index');


});


