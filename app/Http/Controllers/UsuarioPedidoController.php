<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pedido;

class UsuarioPedidoController extends Controller
{
    
    public function index(User $usuario)
    {
        $categoria = Categoria::all();
        return response()->json($categoria->pedidos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $usuario)
    {
        $pedido = new Pedido($request->all());
        $pedido->user_id=$usuario->id;
        $pedido->save();

        return response()->json($pedido, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usuario, string $id)
    {
        $pedido = Pedido::find($id);

        if(!$pedido || $pedido->user_id != $usuario->id){
            return response()->json(['error' => 'El pedido no pertenece al usuario'], 404);
        }
        return response()->json($pedido, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $usuario, Request $request, Pedido $pedido)
    {
        if($pedido->user_id != $usuario->id){
            return response()->json(['error' => 'El pedido no pertenece al usuario'], 404);
        }

        $pedido->update($request->all());
        return response()->json($pedido, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario, string $id)
    {
        $pedido = Pedido::find($id);

        if(!$pedido || $pedido->user_id != $usuario->id){
            return response()->json(['error' => 'El pedido no pertenece al usuario'], 404);
        }

        $pedido->delete();
        return response()->json($pedido, 200);
    }


}

// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index(User $user)
//     {
//         return response()->json($user->pedidos,200);
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request, User $user)
//     {
//         $pedido= new Pedido($request->all());
//         $pedido->user_id = $user->id;
//         $pedido->save();
//         return response()->json($pedido, 201);
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(User $user, Pedido $pedido)
//     {
//         if ($pedido->user_id != $user->id) {
//             return response()->json(['error' => 'El producto no pertenece a la categoria'], 404);
//         }
//         return response()->json($pedido, 200);
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(User $user, Request $request, Pedido $pedido)
//     {
//         if($pedido->user_id != $user->id){
//             return response()->json(['error' => 'El producto no pertenece a la categoria'], 404);
//         }
//         $pedido->update($request->all());
//         return response()->json($pedido, 200);
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(User $user, Pedido $pedido)
//     {
//         if($pedido->user_id != $user->id){
//             return response()->json(['error' => 'El producto no pertenece a la categoria'], 404);
//         }

//         $pedido->delete();
//         return response()->json(null, 204);
//     }
// }
