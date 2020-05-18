<?php

use Illuminate\Http\Request;
use App\Shoppinglist;

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

Route::group(['middleware' => ['api', 'cors']], function () {
    Route::get('lists', 'ShoppinglistController@index');
    //Route::get('lists/{title}', 'ShoppinglistController@findByTitle');
    Route::get('list/{id}', 'ShoppinglistController@getSingle');
    Route::put('list/{id}', 'ShoppinglistController@updateComments');
    //Route::get('freelists', 'ShoppinglistController@getFreeLists');
    //Route::get('vlists{id}', 'ShoppinglistController@getVolunteersLists');
    Route::get('user/{id}', 'ShoppinglistController@getUserById');
    Route::post('admin', 'ShoppinglistController@save');
    Route::put('admin/{id}', 'ShoppinglistController@update');
    Route::delete('list/{id}', 'ShoppinglistController@delete');
    Route::post('auth/login', 'Auth\ApiAuthController@login');
});

