<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as ValidationException;

class CategoriaProductoController extends Controller
{
    public function index(Request $request, $categoria)
    {
        $categoria = Categoria::find($categoria);
        if ($categoria == null) {
            return response()->json(['error' => 'Categoria no encontrada'], 404);
        }

        // Filtrado de parametros
        $query = $categoria->productos();
        if ($request->has('precio_min')) {
            $query->where('precio', '>=', $request->input('precio_min'));
        }
        if ($request->has('precio_max')) {
            $query->where('precio', '<=', $request->input('precio_max'));
        }

        // Implementar ordenamiento
        if ($request->has('sort')) {
            $sortFields = explode(',', $request->input('sort'));
            foreach ($sortFields as $field) {
                if (str_ends_with($field, '_desc')) {
                    $query->orderBy(str_replace('_desc', '', $field), 'desc');
                } else {
                    $query->orderBy(str_replace('_asc', '', $field), 'asc');
                }
            }
        }
        $perPage = $request->input('per_page', 10);
        $productos = $query->paginate($perPage);

        if ($request->has('fields')) {
            $fields = explode(',', $request->input('fields'));
            $productos = $productos->map(function ($producto) use ($fields) {
                return $producto->only($fields);
            });
        }
        return response()->json($productos, 200);
    }

    public function store(Request $request, $categoria)
    {
        $categoria = Categoria::find($categoria);
        if ($categoria == null) {
            return response()->json(['error' => 'Categoria no encontrada'], 404);
        }
        try {
            $validateData = $request->validate([
                'nombre' => 'required|string|max:255',
                'precio' => 'required|numeric|min:0',
                'descripcion' => 'required|string|max:255'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $producto = new Producto($validateData);
        $producto->categoria_id = $categoria->id;
        $producto->save();
        return response()->json($producto, 201);
    }

    public function show(Request $request, $categoria, $producto)
    {
        $categoria = Categoria::find($categoria);
        if ($categoria == null) {
            return response()->json(['error' => 'Categoria no encontrada'], 404);
        }
        $producto = Producto::find($producto);
        if (!$producto || $producto->categoria_id != $categoria->id) {
            return response()->json(['error' => 'El producto no pertenece a la categoria o no existe'], 404);
        }

        if ($request->has('fields')) {
            $fields = explode(',', $request->input('fields'));
            $producto = $producto->only($fields);
        }
        return response()->json($producto, 200);
    }

    public function update(Request $request, $categoria, $producto)
    {
        $categoria = Categoria::find($categoria);
        if ($categoria == null) {
            return response()->json(['error' => 'Categoria no encontrada'], 404);
        }
        $producto = Producto::find($producto);

        if (!$producto || $producto->categoria_id != $categoria->id) {
            return response()->json(['error' => 'El producto no pertenece a la categoria o no existe'], 404);
        }

        try {
            $validateData = $request->validate([
                'nombre' => 'required|string|max:255',
                'precio' => 'required|numeric|min:0',
                'descripcion' => 'required|string|max:255'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $producto->update($validateData);

        return response()->json($producto, 200);
    }

    public function destroy($categoria, $producto)
    {
        $categoria = Categoria::find($categoria);
        if ($categoria == null) {
            return response()->json(['error' => 'Categoria no encontrada'], 404);
        }
        $producto = Producto::find($producto);
        if (!$producto || $producto->categoria_id != $categoria->id) {
            return response()->json(['error' => 'El producto no pertenece a la categoria o no existe'], 404);
        }

        $producto->delete();
        return response()->json(null, 204);
    }
}