<?php

use App\Http\Controllers\Admon\MenuController;
use App\Http\Controllers\V1\Admon\PermissionController;
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

# publicRoutes
Route::post('auth/login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::post('auth/register', [AuthController::class, 'register']);
Route::get('permission/{roleId}', [PermissionController::class, 'getModulePermissions'])->middleware('auth:api');
# end publicRoutes

Route::group([
    'middleware' => 'jwt.auth',
], function () {
    require __DIR__ . '/api_v1.php';
    require __DIR__ . '/api_v2.php';
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
