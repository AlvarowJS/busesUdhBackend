<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\V1\GoogleAuthController as GoogleAuth;
use App\Http\Controllers\Api\V1\StatusController as Status;
use App\Http\Controllers\Api\V1\AuthController as Auth;
use App\Http\Controllers\Api\V1\BuseController as Buses;
use App\Http\Controllers\Api\V1\ParaderoController as Paradero;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Rutas para el chofer
Route::post('/driver/login', [Auth::class, 'login']);
Route::post('/driver/register', [Auth::class, 'register']);

// Rutas para el psajero
Route::middleware('web')->get('login', [GoogleAuth::class, 'redirectToProvider']);
Route::middleware('web')->get('/google-callback', [GoogleAuth::class, 'handleProviderCallback']);
Route::post('/login-user', [GoogleAuth::class, 'loginWithCredentials']);

Route::post('/google-register', [GoogleAuth::class, 'registroWithGoogle']);

// Parederos:
Route::apiResource('/paradero', Paradero::class);

// Testers


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth', [GoogleAuth::class, 'authToken']);
    Route::get('/status', [Status::class, 'index']);
    Route::get('/buses-activos', [Buses::class, 'mostrarBusesActivos']);
    // Route::get('/status/{id}', [Status::class, 'show']);
    // Route::post('/status', [Status::class, 'store']);
    // Route::put('/status/{id}', [Status::class, 'update']);
    // Route::delete('/status/{id}', [Status::class, 'destroy']);
});

Route::middleware('auth:sanctum:driver')->group(function () {
    Route::post('/driver/logout', [Auth::class, 'logout']);
    Route::post('/driver/update-status', [Status::class, 'updateStatus']);
    Route::post('/driver/asignar-status', [Status::class, 'asignarEstado']);
    Route::post('/driver/crear-bus', [Buses::class, 'store']);
    Route::get('/driver/mostrar-bus', [Buses::class, 'index']);
    Route::post('/driver/asignar-bus', [Buses::class, 'asignarBus']);
    Route::get('/driver/terminar-bus', [Buses::class, 'terminarBus']);
});
// crear unas rutas protegidas del estado para el token de drivers y otras para el token de users
