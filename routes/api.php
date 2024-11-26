<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaProductoController;
use App\Http\Controllers\UsuarioPedidoController;
use App\Http\Controllers\CategoriaController;

Route::get('/user', function (Request $request) {
        return $request->user();
})->middleware('auth:sanctum');


Route::get(
        'categorias/{categorias}/productos',
        [CategoriaProductoController::class, 'index']
);

Route::post(
        'categorias/{categorias}/productos',
        [CategoriaProductoController::class, 'store']
);

Route::get(
        'categorias/{categorias}/productos/{producto} ',
        [CategoriaProductoController::class, 'show']
);

Route::put(
        'categorias/{categorias}/productos/{producto}',
        [CategoriaProductoController::class, 'update']
);

Route::delete(
        'categorias/{categorias}/productos/{producto}',
        [CategoriaProductoController::class, 'destroy']
);



Route::get(
        'usuarios/{usuario}/pedidos/{pedido}',
        [UsuarioPedidoController::class, 'index']
);

Route::post(
        'usuarios/{usuario}/pedidos/{pedido}',
        [UsuarioPedidoController::class, 'store']
);

Route::get(
        'usuarios/{usuario}/pedidos/{pedido}',
        [UsuarioPedidoController::class, 'show']
);

Route::put(
        'usuarios/{usuario}/pedidos/{pedido}',
        [UsuarioPedidoController::class, 'update']
);

Route::delete(
        'usuarios/{usuario}/pedidos/{pedido}',
        [UsuarioPedidoController::class, 'destroy']
);


Route::get(
        'categorias',
        [CategoriaController::class, 'index']
);

Route::post(
        'categorias',
        [CategoriaController::class, 'store']
);

Route::get(
        'categorias/{categoria}',
        [CategoriaController::class, 'show']
);

Route::put(
        'categorias/{categoria}',
        [UsuarioPedidoController::class, 'update']
);

Route::delete(
        'categorias/{categoria}',
        [UsuarioPedidoController::class, 'destroy']
);
