<?php

use App\Http\Controllers\Admon\RoleController;
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

#region AuthenticationRoutes

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router){

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:login');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'user']);

});

#endregion AuthenticationRoutes

#region Roles

Route::group([
    'middleware' => 'api',
    'prefix' => 'roles'
], function ($route){
    Route::post('create',[RoleController::class, 'store']);
    Route::get('show/{id}',[RoleController::class, 'show']);
    Route::put('update/{id}',[RoleController::class, 'update']);
    Route::delete('delete/{id}', [RoleController::class, 'destroy']);
});

#endregion Roles



