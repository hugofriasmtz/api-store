<?php

use App\Http\Controllers\CategoriaProductoController;
use Illuminate\http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/user', function (Request $request){
        return $request->user();
    })->middleware('auth:sanctum');

Route::get('categorias/{categoria}/productos',
        [CategoriaProductoController::class, 'index']);

Route::post('categorias/{categoria}/productos',
        [CategoriaProductoController::class, 'store']);

Route::get('categorias/{categoria}/productos/{producto}',
        [CategoriaProductoController::class, 'destroy']);
