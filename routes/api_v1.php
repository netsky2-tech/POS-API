<?php

use App\Http\Controllers\V1\Admon\MenuController;
use App\Http\Controllers\V1\Admon\RoleController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\DepartmentController;
use App\Http\Controllers\V1\MunicipalityController;
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
], function ($router) {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

#endregion AuthenticationRoutes

#region Roles

Route::group([
    'prefix' => 'v1/roles'
], function ($route) {
    Route::get('index', [RoleController::class, 'index'])->name('v1.roles.index');
    Route::post('create', [RoleController::class, 'store'])->name('v1.roles.store');
    Route::get('show/{id}', [RoleController::class, 'show'])->name('v1.roles.show');
    Route::put('update/{role}', [RoleController::class, 'update'])->name('v1.roles.update');
    Route::delete('delete/{role}', [RoleController::class, 'destroy'])->name('v1.roles.delete');
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

#region Departments

Route::group([
    'prefix' => 'v1/departments'
], function ($route) {
    Route::get('index', [DepartmentController::class, 'index'])->name('v1.departments.index');
    Route::post('create', [DepartmentController::class, 'store'])->name('v1.departments.store');
    Route::get('show/{id}', [DepartmentController::class, 'show'])->name('v1.departments.show');
    Route::put('update/{role}', [DepartmentController::class, 'update'])->name('v1.departments.update');
    Route::delete('delete/{role}', [DepartmentController::class, 'destroy'])->name('v1.departments.delete');
});

#endregion Departments

#region Municipality

Route::group([
    'prefix' => 'v1/departments'
], function ($route) {
    Route::get('index', [MunicipalityController::class, 'index'])->name('v1.municipalities.index');
    Route::post('create', [MunicipalityController::class, 'store'])->name('v1.municipalities.store');
    Route::get('show/{id}', [MunicipalityController::class, 'show'])->name('v1.municipalities.show');
    Route::put('update/{role}', [MunicipalityController::class, 'update'])->name('v1.municipalities.update');
    Route::delete('delete/{role}', [MunicipalityController::class, 'destroy'])->name('v1.municipalities.delete');
});

#endregion Municipality

#region Currency
Route::group([
    'prefix' => 'v1/currencies'
], function ($route) {
    Route::get('index', [\App\Http\Controllers\CurrencyController::class, 'index'])->name('v1.currencies.index');
    Route::post('create', [\App\Http\Controllers\CurrencyController::class, 'store'])->name('v1.currencies.store');
    Route::get('show/{id}', [\App\Http\Controllers\CurrencyController::class, 'show'])->name('v1.currencies.show');
    Route::put('update', [\App\Http\Controllers\CurrencyController::class, 'update'])->name('v1.currencies.update');
    Route::delete('delete', [\App\Http\Controllers\CurrencyController::class, 'update'])->name('v1.currencies.update');
});
#endregion Currency

##region ExchangeRate
Route::group([
    'prefix' => 'v1/exchanges-rates'
], function ($route) {
    Route::get('index', [\App\Http\Controllers\ExchangeRateController::class, 'index'])->name('v1.exchanges.index');
    Route::post('create', [\App\Http\Controllers\ExchangeRateController::class, 'store'])->name('v1.exchanges.store');
    Route::get('show/{id}', [\App\Http\Controllers\ExchangeRateController::class, 'show'])->name('v1.exchanges.show');
    Route::put('update', [\App\Http\Controllers\ExchangeRateController::class, 'update'])->name('v1.exchanges.update');
    Route::delete('delete', [\App\Http\Controllers\ExchangeRateController::class, 'update'])->name('v1.exchanges.update');
});
#endregion ExchangeRate
