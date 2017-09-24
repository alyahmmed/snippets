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

Route::get('blocks', 'BlockController@index');
Route::get('blocks/{block}', 'BlockController@show');
Route::post('blocks', 'BlockController@store');
Route::put('blocks/{block}', 'BlockController@update');
Route::delete('blocks/{block}', 'BlockController@delete');
