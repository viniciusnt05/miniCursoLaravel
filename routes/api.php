<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ManutencaoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\VeiculoController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/clientes')->group(function () {
    Route::get('/', [ClienteController::class, 'index']);
    Route::get('/{id}', [ClienteController::class, 'show']);
    Route::post('/', [ClienteController::class, 'store']);
    Route::patch('/{id}', [ClienteController::class, 'update']);
    Route::delete('/{id}', [ClienteController::class, 'destroy']);
});

Route::prefix('/veiculos')->group(function () {
    Route::get('/', [VeiculoController::class, 'index']);
    Route::get('/{id}', [VeiculoController::class, 'show']);
    Route::post('/', [VeiculoController::class, 'store']);
    Route::patch('/{id}', [VeiculoController::class, 'update']);
    Route::delete('/{id}', [VeiculoController::class, 'destroy']);
});

Route::prefix('/reservas')->group(function () {
    Route::get('/', [ReservaController::class, 'index']);
    Route::get('/{id}', [ReservaController::class, 'show']);
    Route::post('/', [ReservaController::class, 'store']);
    Route::patch('/{id}', [ReservaController::class, 'update']);
    Route::delete('/{id}', [ReservaController::class, 'destroy']);
});

Route::prefix('/manutencoes')->group(function () {
    Route::get('/', [ManutencaoController::class, 'index']);
    Route::get('/{id}', [ManutencaoController::class, 'show']);
    Route::post('/', [ManutencaoController::class, 'store']);
    Route::patch('/{id}', [ManutencaoController::class, 'update']);
    Route::delete('/{id}', [ManutencaoController::class, 'destroy']);
});

Route::prefix('/categorias')->group(function () {
    Route::get('/', [CategoriaController::class, 'index']);
    Route::get('/{id}', [CategoriaController::class, 'show']);
    Route::post('/', [CategoriaController::class, 'store']);
    Route::patch('/{id}', [CategoriaController::class, 'update']);
    Route::delete('/{id}', [CategoriaController::class, 'destroy']);
});

