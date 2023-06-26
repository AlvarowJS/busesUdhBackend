<?php

namespace App\Http\Controllers\Api\V1;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class GoogleAuthController extends Controller
{
    protected function guard()
    {
        return Auth::guard('users');
    }
    public function loginWithCredentials(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $credentials = request(['email', 'password']);

        if (Auth::guard('users')->attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('user_token')->plainTextToken;

            return response()->json(['token' => $token]);
        }
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'No Autorizado'], 401);
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();

        $userExists = User::where('external_id', $user->id)->where('external_auth', 'google')->first();
        if ($userExists) {
            Auth::login($userExists);
            // Generamos un token de autenticación para el usuario
            $token = $userExists->createToken('Personal Access Token')->plainTextToken;

            // Devolvemos el token en la respuesta
            return response()->json([
                'access_token' => $token,
            ]);
        } else {
            $email = $user->email;
            $codigo = substr($email, 0, strpos($email, '@'));
            $userNew = User::create([
                'name' => $user->name,
                'email' => $email,
                'password' => Hash::make($codigo),
                'codigo' => $codigo,
                'avatar' => $user->avatar,
                'external_id' => $user->id,
                'external_auth' => 'google',
            ]);

            Auth::login($userNew);
            $token = $userNew->createToken('Personal Access Token')->accessToken;
            return response()->json([
                'access_token' => $token,
                'data' => $userNew
            ]);
        }
    }

}
