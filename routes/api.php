<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\V1\GoogleAuthController as GoogleAuth;
use App\Http\Controllers\Api\V1\EstadoController as Estado;

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
// Route::get('login', [GoogleAuth::class,'redirectToProvider']);
Route::middleware('web')->get('login', [GoogleAuth::class, 'redirectToProvider']);

// Route::get('login/callback', [GoogleAuth::class,'handleProviderCallback']);
Route::middleware('web')->get('/google-callback', [GoogleAuth::class, 'handleProviderCallback']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/estados', [Estado::class, 'index']);
    Route::get('/estados/{id}', [Estado::class, 'show']);
    Route::post('/estados', [Estado::class, 'store']);
    Route::put('/estados/{id}', [Estado::class, 'update']);
    Route::delete('/estados/{id}', [Estado::class, 'destroy']);
});
