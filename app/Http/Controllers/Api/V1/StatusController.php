<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Statu;

class StatusController extends Controller
{

    public function index()
    {
        $statuss = Statu::all();
        return response()->json($statuss);
    }

    public function show($id)
    {
        $status = Statu::find($id);
        return response()->json($status);
    }

    public function store(Request $request)
    {
        $status = new Statu();
        $status->nombre = $request->nombre;
        $status->descripcion = $request->descripcion;
        $status->save();
        return response()->json($status);
    }

    public function update(Request $request, $id)
    {
        $status = Statu::find($id);
        $status->nombre = $request->nombre;
        $status->descripcion = $request->descripcion;
        $status->save();
        return response()->json($status);
    }

    public function destroy($id)
    {
        $status = Statu::find($id);
        $status->delete();
        return response()->json('status eliminado exitosamente');
    }

}
