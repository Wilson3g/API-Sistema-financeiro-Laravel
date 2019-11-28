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


Route::prefix('v1')->namespace('Api')->group(function(){

    Route::post('login', 'Auth\\JwtController@login');
    Route::get('logout', 'Auth\\JwtController@logout');

    Route::post('users', 'UserController@store');

    Route::group(['middleware'=>['jwt-auth']], function (){

        Route::name('registros.')->group(function(){
            Route::resource('registros', 'RegistrosController');
            Route::put('baixas/{id}', 'RegistrosController@baixa');
        });

        Route::name('users.')->group(function(){
            Route::resource('users', 'UserController')->except('store');
        });

        Route::name('tag.')->group(function(){
            Route::get('/tags/{id}/registros', 'TagsController@tags');
            Route::resource('tags', 'TagsController');
        }); 
    });
});