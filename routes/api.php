<?php

use Illuminate\Http\Request;
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

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="Documentación de la API de mi aplicación",
 *     @OA\Contact(
 *         email="contact@example.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * @OA\Server(
 *      url="http://localhost/api",
 *     description="Servidor de desarrollo"
 * )
 */


#region publicRoutes
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
#endregion publicRoutes


Route::middleware(['auth:api', 'throttle:60,1'])->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    // Otras rutas aquí
});

