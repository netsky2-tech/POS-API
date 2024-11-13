<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

#region publicRoutes
Route::post('login', [AuthController::class, 'login'])->middleware('throttle:login');
#endregion publicRoutes


Route::middleware(['auth.jwt'])->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    // Otras rutas aquí
});

