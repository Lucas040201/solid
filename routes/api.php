<?php

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


Route::prefix('user')->group(function() {
   Route::controller(UserController::class)->group(function() {
       Route::post('/{userType}', 'create');
       Route::get('/', 'index');
   });
});

Route::prefix('auth')->group(function() {
   Route::controller(AuthController::class)->group(function () {
        Route::middleware('auth:sanctum')->get('/me', 'currentUser');
        Route::post('/{userType}', 'login');
   });
});
