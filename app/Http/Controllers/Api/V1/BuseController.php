<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Buse;
use Illuminate\Http\Request;

class BuseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
