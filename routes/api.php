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

 Route::group(['middleware' => ['api']], function () {

    Route::get('/', function () {
        return response()->json(['message' => 'Usuários API', 'status' => 'Conectado']);;
    });

    Route::resource('usuarios', 'UsuariosController');

});


Route::get('/', function () {
    return redirect(route('usuarios.index'));
});
