<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $categorias = Categoria::all();

    if ($request->has('fields')) {
        $fields = explode(',', $request->input('fields'));
        $categorias = $categorias->map(function ($categoria) use ($fields) {
            return $categoria->only($fields);
        });
    }

    return response()->json($categorias, 200);
}



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validateData = $request->validate([
                'nombre' => 'required|string|max:255'
            ]);
        }catch(ValidationException $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
        $categoria = new Categoria($validateData);
        $categoria->save();
        return response()->json($categoria, 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $categoria = Categoria::find($id);

        if($categoria == null){
            return response()->json("Categoria no encontrada",404);
        }
        if ($request->has('fields')){
            $fields = explode(',', $request->input('fields'));
            $categoria = $categoria->only($fields);
            }
        return response()->json($categoria,200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categoria = Categoria::find($id);
        if($categoria == null){
            return response()->json("Categoria no encontrada",404);
        }
        try {
        $validateData = $request->validate([
            'nombre' => 'required|string|max:255'
        ]);
        }catch(ValidationException $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
        $categoria->update($validateData);
        return response()->json($categoria,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::find($id);
        if($categoria == null){
            return response()->json("Categoria no encontrada",404);

        }
        $categoria->delete();
        return response()->json(null,204);
    }
}
