<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Buse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuseController extends Controller
{

    public function asignarBus(Request $request)
    {
        $user = Auth::user();
        $idBus = $request->id;
        $idUser = $user->id;

        $busSearch = Buse::find($idBus);
        $busSearchActual = $busSearch->driver_id;

        $busActual = Buse::where('driver_id', $idUser)->first();

        if ($idUser == $busSearchActual) {
            return response()->json([
                'success' => 'bus ya asignado'
            ], 201);
        } else {
            if ($busSearchActual == null) {
                if ($busActual) {
                    $busActual->driver_id = null;
                    $busActual->save();
                }
                $busSearch->driver_id = $idUser;
                $busSearch->save();

                return response()->json([
                    'message' => 'bus asignado',
                    'data' => $busSearch
                ]);
            } else {
                return response()->json([
                    'error' => 'bus no disponible'
                ], 401);
            }

        }
    }
    public function terminarBus()
    {

        $user = Auth::user();
        $idUser = $user->id;

        $buse = Buse::where('driver_id', $idUser)->first();
        
        // return $buse->id;
        $idBus = $buse->id;
        $bus = Buse::find($idBus);

        if ($idUser == $buse->driver_id) {
            $bus->driver_id = null;
            $bus->statu_id = null;
            $bus->save();
            return response()->json([
                'message' => 'Bus finalizado',
                'data' => $bus
            ], 200);
        } else {
            return response()->json([
                'error' => 'bus no pertenece al usuario'
            ], 401);
        }


    }
    public function mostrarBusesActivos()
    {
        $busesActivos = Buse::where('activo', 1)->get();

        return response()->json($busesActivos);
    }
    public function index()
    {
        $user = Auth::user();
        $userActual = $user->id;
        $buses = Buse::all();
        foreach ($buses as $bus) {
            $bus->status = $bus->driver_id === null ? 'disponible' : 'ocupado';
            $bus->id_user_actual = $userActual == $bus->driver_id ? $bus->driver_id : null;
        }

        return response()->json($buses);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $buses = new Buse();
        $buses->numero = $request->numero;
        $buses->placa = $request->placa;
        $buses->save();
        return response()->json($buses);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
