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
    public function authToken(Request $request)
    {
        $token = $request->header('Authorization');
        $user = Auth::user();
        $tableName = $user->getTable();
        $user->token = $token;
        $user->table = $tableName;
        return $user;
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

            return response()->json([
                'token' => $token,
                'name' => $user->name,
                'email' => $user->email,
                'codigo' => $user->codigo,
                'avatar' => $user->avatar,
                'table' => 'users'
            ]);
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
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
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
            $domainToCheck = "@udh.edu.pe";

            if (strpos($email, $domainToCheck) !== false) {
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
            } else {
                return "error";
            }
        }
    }

    public function registroWithGoogle(Request $request)
    {
        $codigo = $request->email;
        $division = explode("@", $codigo);
        $codigo = $division[0];
        $dominio = $division[1];
        try {
            if ($dominio != "udh.edu.pe") {
                return response()->json([
                    'error' => 'El usuario no esta permitido'
                ], 401);
            } else {
                $existingUser = User::where('email', $request->email)->first();

                if ($existingUser) {
                    if ($existingUser->external_id == $request->id) {
                        $token = $existingUser->createToken('access_token')->plainTextToken;
                        return response()->json([
                            // 'access_token' => $token,
                            // 'data' => $existingUser
                            'token' => $token,
                            'name' => $existingUser->name,
                            'email' => $existingUser->email,
                            'codigo' => $existingUser->codigo,
                            'avatar' => $existingUser->avatar,
                            'table' => 'users'
                        ], 200);
                    } else {
                        return response()->json([
                            'errror' => 'El external id no coincide'
                        ], 403);
                    }
                } else {
                    $student = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($codigo),
                        'codigo' => $codigo,
                        'avatar' => $request->photo,
                        'external_id' => $request->id,
                        'external_auth' => 'google',
                    ]);

                    $token = $student->createToken('access_token')->plainTextToken;
                    return response()->json([
                        // 'access_token' => $token,
                        // 'data' => $student
                        'token' => $token,
                        'name' => $student->name,
                        'email' => $student->email,
                        'codigo' => $student->codigo,
                        'avatar' => $student->avatar,
                        'table' => 'users'
                    ], 201);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrio un errror al registrar'], 500);
        }
    }
}
