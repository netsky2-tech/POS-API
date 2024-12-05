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
    Route::get('index',[RoleController::class, 'index'])->name('v1.roles.index');
    Route::post('create',[RoleController::class, 'store'])->name('v1.roles.store');
    Route::get('show/{id}',[RoleController::class, 'show'])->name('v1.roles.show');
    Route::put('update/{role}',[RoleController::class, 'update'])->name('v1.roles.update');
    Route::delete('delete/{role}', [RoleController::class, 'destroy'])->name('v1.roles.delete');
});

#endregion Roles



