<?php


use App\Http\Controllers\V1\Admon\RoleController;
use App\Http\Controllers\V1\AuthController;
use Illuminate\Support\Facades\Route;

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
    'prefix' => 'v1/auth'
], function ($router){
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    Route::post('refresh', [AuthController::class, 'refresh']);

});

#endregion AuthenticationRoutes

#region Roles

Route::group([
    'prefix' => 'v1/roles'
], function ($route){
    Route::get('index',[RoleController::class, 'index']);
    Route::post('create',[RoleController::class, 'store']);
    Route::get('show/{id}',[RoleController::class, 'show']);
    Route::put('update/{id}',[RoleController::class, 'update']);
    Route::delete('delete/{id}', [RoleController::class, 'destroy']);
});

#endregion Roles



