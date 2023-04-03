<?php

namespace App\Http\Controllers\Api\V1;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class GoogleAuthController extends Controller
{
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
            $userNew = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'external_id' => $user->id,
                'external_auth' => 'google',
            ]);

            Auth::login($userNew);
            $token = $userNew->createToken('Personal Access Token')->accessToken;
            return response()->json([
                'access_token' => $token,
            ]);
        }
    }

}
