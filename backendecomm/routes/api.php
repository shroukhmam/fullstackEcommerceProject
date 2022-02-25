<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'API'], function () {
        Route::post('/register','AuthController@register');
        Route::post('/login','AuthController@login');
         ////////////////slider//////////////////////////
         Route::post('/add-slider','SliderController@store'); 
         Route::get('/view-slider','SliderController@index');
         Route::get('/view-blogger','BloggerController@index');
         Route::get('/view-review','ReviewController@index');
         
         ////////////////product user////////////////////////////
         Route::get('/show-product/{category}','ProductController@showAll'); 
         Route::get('/all-product','ProductController@showAllCategoryProduct');
         Route::get('/get-one-product/{id}','ProductController@getOneProduct');
         Route::get('/allCategory','CategoryController@allcategory');

         Route::post('/add-to-cart','CartController@addToCart');
         Route::get('/get-cart','CartController@getCart');
         Route::post('/update-cart/{id}/{scope}','CartController@updateCart');
         Route::post('/delete-cart/{id}','CartController@deleteCart');
         Route::post('/delete-all-cart','CartController@deleteAllCart');
         Route::post('/place-order','CheckoutController@placeorder');
         Route::post('/validate-order','CheckoutController@validateorder');
        Route::middleware('auth:sanctum')->group(function () {

            Route::post('/logout','AuthController@logout');
        });
        Route::middleware(['auth:sanctum','isAPIAdmin'])->group(function () {
            Route::get('/checkingAuthenticated',function(){
                   return response()->json(['message'=>'You are in','status'=>200],200);
            });
            Route::post('/category','CategoryController@store');
            Route::get('/viewcategory','CategoryController@index');
            Route::get('/edit-category/{id}','CategoryController@edit');
            Route::put('/update-category/{id}','CategoryController@update');
            Route::delete('delete-category/{id}','CategoryController@destroy');
            // Route::get('/allCategory','CategoryController@allcategory');
             ///////////////////////product//////////////////
             Route::post('/add-product','ProductController@store'); 
             Route::get('/view-product','ProductController@index');
             Route::get('/edit-product/{id}','ProductController@edit');
             Route::put('/update-product/{id}','ProductController@update');
             Route::delete('delete-product/{id}','ProductController@destroy');
             Route::post('/add-image/{id}','ImageController@store'); 
             Route::get('/get-image/{id}','ImageController@index'); 
             Route::delete('/delete-image/{id}','ImageController@destroy');
             Route::post('/delete-size/{id}','FeatureController@destroySize');
             Route::post('/delete-color/{id}','FeatureController@destroyColor');
             ///////////////////////////blogger////////////////
             Route::post('/add-blogger','BloggerController@store'); 
             Route::get('/edit-blogger/{id}','BloggerController@edit');
             Route::post('/update-blogger/{id}','BloggerController@update');
             Route::delete('delete-blogger/{id}','BloggerController@destroy');


             ////////////////////////////////review////////////////////
             Route::post('/add-review','ReviewController@store'); 
             Route::get('/edit-review/{id}','ReviewController@edit');
             Route::post('/update-review/{id}','ReviewController@update');
             Route::delete('delete-review/{id}','ReviewController@destroy');

             /////////////////////////////////order//////////////////
             Route::get('/view-order','OrderController@index');
             Route::delete('delete-order/{id}','OrderController@destroy');
        });
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
