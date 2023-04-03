<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estado;

class EstadoController extends Controller
{
    public function index()
    {
        $estados = Estado::all();
        return response()->json($estados);
    }

    public function show($id)
    {
        $estado = Estado::find($id);
        return response()->json($estado);
    }

    public function store(Request $request)
    {
        $estado = new Estado();
        $estado->nombre = $request->nombre;
        $estado->descripcion = $request->descripcion;
        $estado->save();
        return response()->json($estado);
    }

    public function update(Request $request, $id)
    {
        $estado = Estado::find($id);
        $estado->nombre = $request->nombre;
        $estado->descripcion = $request->descripcion;
        $estado->save();
        return response()->json($estado);
    }

    public function destroy($id)
    {
        $estado = Estado::find($id);
        $estado->delete();
        return response()->json('Estado eliminado exitosamente');
    }
}
