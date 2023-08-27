<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Statu;
use App\Models\Buse;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    // Este debe confirmar si el bus tiene un driver asignado para poder asignarse
    // Recordar que cuando se termine un bus tambien elimine el estado
    public function asignarEstado(Request $request)
    {
        $user = Auth::user();
        $idEstado = $request->id;
        $idUser = $user->id;

        $busStatus = Buse::where('driver_id', $idUser)->first();

        if ($busStatus) {
            $busStatus->statu_id = $idEstado;
            $busStatus->save();
            return response()->json([
                'message' => 'estado asignado',
                'data' => $busStatus
            ], 201);
        } else {
            return response()->json([
                'error' => 'bus no activo'
            ], 401);
        }


    }

    public function updateStatus(Request $request)
    {
        $user = Auth::user();
        return $user;
    }
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
