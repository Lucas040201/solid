<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use \App\Http\Controllers\Api\AuthController;

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

Route::prefix('user')->group(function() {
   Route::controller(UserController::class)->group(function() {
       Route::post('/{provider}', 'create');
       Route::get('/', 'index');
   });
});

Route::prefix('auth')->group(function() {
   Route::controller(AuthController::class)->group(function () {
      Route::post('/{provider}', 'login');
   });
});
