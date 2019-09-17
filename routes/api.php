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

    // Rotas dos registros
    Route::name('registro.')->group(function(){
        Route::resource('registro', 'RegistrosController'); //api/v1/registro
        Route::put('pagar/{id}', 'RegistrosController@pay');
        Route::put('receber/{id}', 'RegistrosController@receive');
    });

    // Rotas dos usuários
    Route::name('user.')->group(function(){
        Route::resource('user', 'UserController');
    });

    // Rotas das tags
    Route::name('tag.')->group(function(){
        Route::get('/tags/{id}/registros', 'TagsController@tags');
        Route::resource('tag', 'TagsController');
    });
});