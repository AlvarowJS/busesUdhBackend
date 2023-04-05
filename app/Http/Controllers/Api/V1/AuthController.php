<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Driver;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    // use AuthenticatesUsers, RegistersUsers;

    protected function guard()
    {
        return Auth::guard('drivers');
    }

    public function login(Request $request)
    {
        // $credentials = $request->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $credentials = request(['email', 'password']);

        if (Auth::guard('drivers')->attempt($credentials)) {
            $driver = Driver::where('email', $request->email)->first();
            $token = $driver->createToken('driver_token')->plainTextToken;

            return response()->json(['token' => $token]);
        }
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'No Autorizado'], 401);
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function register(Request $request)
    {

        // $data = $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:drivers'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);

        // Crear un nuevo conductor con los datos proporcionados.
        $driver = Driver::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generar un token de acceso para el conductor.
        $token = $driver->createToken('driver_token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }
}
