<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teste;

use App\Events\privateEvent;
use App\Events\testeEvent;
use App\Http\Controllers\AuthController;
// use Tymon\JWTAuth\Http\Middleware\Authenticate;
use App\Http\Middleware\JwtMiddleware;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





Route::post('/login3',[AuthController::class,'login']);
Route::post('/register_user_post',[AuthController::class,'register_user']);


Route::prefix('v1')->middleware([JwtMiddleware::class])->group(function () {
    Route::get('/checkTK',[AuthController::class,'checkToken']);
    Route::post('me',[AuthController::class,'me']);
    Route::get('/logout',[AuthController::class,'logout']);
    Route::post('refresh',[AuthController::class,'refresh']);

});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/testando', [Teste::class, 'teste']);