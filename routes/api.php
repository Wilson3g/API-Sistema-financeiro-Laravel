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

    // Rota de login e logout com autenticação
    Route::post('login', 'Auth\\JwtController@login');
    Route::get('logout', 'Auth\\JwtController@logout');

    Route::post('users', 'UserController@store');

    Route::group(['middleware'=>['jwt-auth']], function (){
        // Rotas dos registros
        Route::name('registros.')->group(function(){
            Route::resource('registros', 'RegistrosController'); //api/v1/registro
            Route::put('baixas/{id}', 'RegistrosController@baixa');
        });

        // Rotas dos usuários
        Route::name('users.')->group(function(){
            Route::resource('users', 'UserController')->except(['store']);
        });

        // Rotas das tags
        Route::name('tag.')->group(function(){
            Route::get('/tags/{id}/registros', 'TagsController@tags');
            Route::resource('tags', 'TagsController');
        }); 
    });
});