<?php

use App\Http\Controllers\Admon\MenuController;
use App\Http\Controllers\Admon\PermissionController;
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

# publicRoutes
Route::post('auth/login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::post('auth/register', [AuthController::class, 'register']);
Route::get('permission/{roleId}', [PermissionController::class, 'getModulePermissions'])->middleware('auth:api');
# end publicRoutes

#region AuthenticationRoutes

Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'auth'
], function ($router) {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

#endregion AuthenticationRoutes

#region Roles

Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'roles'
], function ($route) {
    Route::get('index', [RoleController::class, 'index']);
    Route::post('create', [RoleController::class, 'store']);
    Route::get('show/{id}', [RoleController::class, 'show']);
    Route::put('update/{id}', [RoleController::class, 'update']);
    Route::delete('delete/{id}', [RoleController::class, 'destroy']);
});

#endregion Roles

#region Menus
Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'menus'
], function ($route) {
    Route::get('get-all', [MenuController::class, 'getAll']);
});
#endregion Menus
