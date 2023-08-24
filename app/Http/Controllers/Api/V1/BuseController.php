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


        $bus = Buse::find($idBus);
        $bus->driver_id = $idUser;
        $bus->save();

        return response()->json($bus);
    }
    public function terminarBus(Request $request)
    {
        $user = Auth::user();
        $idBus = $request->id;
        // $idUser = $user->id;


        $bus = Buse::find($idBus);
        $bus->driver_id = null;
        $bus->save();

        return response()->json($bus);
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
