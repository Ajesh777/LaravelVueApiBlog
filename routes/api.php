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

// 6: Create Routes for Article CRUD operations:
// 6.1: Create the index Route:
Route::get('articles', 'ArticleController@index');
// 6.2: Route to Single Article:
Route::get('article/{id}', 'ArticleController@show');
// 6.3: Route to New Article:
Route::post('article', 'ArticleController@store');
// 6.4: Route to Update Article:
Route::put('article', 'ArticleController@store');
// 6.5: Route to Delete Article:
Route::delete('article/{id}', 'ArticleController@destroy');