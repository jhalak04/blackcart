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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('stores', 'StoresController@index');
Route::get('stores/{id}', 'StoresController@show');
Route::post('stores','StoresController@add');
Route::put('stores/{id}','StoresController@update');
Route::delete('stores/{id}','StoresController@delete');
Route::get('stores/{id}/products', 'StoresController@show_products');

