<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// // get all data 
// Route::get('api/articles','ArticleController@index');
// // get single data
// Route::get('api/article/{id}','ArticleController@show');
// // create new post
// Route::post('api/article','ArticleController@store');
// // update post
// Route::put('api/article','ArticleController@store');
// // delete post
// Route::delete('api/article/{id}','ArticleController@destroy');

Route::resource('articles','ArticleController');