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

        if ($idUser == $busSearchActual) {
            return response()->json([
                'error' => 'bus ya asignado'
            ], 400);
        } else {
            $busList = Buse::all();
            $dataDriver = collect($busList)->pluck('driver_id')->values()->toArray();

            if (!in_array($idBus, $dataDriver, true)) {
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
    public function terminarBus(Request $request)
    {

        $user = Auth::user();
        $idUser = $user->id;
        $idBus = $request->id;
        $bus = Buse::find($idBus);

        if ($idUser == $idBus) {
            $bus->driver_id = null;
            $bus->statu_id = null;
            $bus->save();
            return response()->json([
                'message' => 'Bus finalizado',
                'data' => $bus
            ], 201);
        } else {
            return response()->json([
                'error' => 'bus no pertenece al usuario'
            ], 401);
        }


    }
    public function index()
    {
        $buses = Buse::all();
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
