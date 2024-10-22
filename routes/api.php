<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ManutencaoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\VeiculoController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');;


//Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/verify-token', function () {
        return response()->json(['message' => 'Token válido'], 200);
    });

    Route::prefix('/usuarios')->group(function () {
        Route::get('/', [UsuarioController::class, 'index']);
        Route::get('/{id}', [UsuarioController::class, 'show']);
        Route::post('/', [UsuarioController::class, 'store']);
        Route::patch('/{id}', [UsuarioController::class, 'update']);
        Route::delete('/{id}', [UsuarioController::class, 'destroy']);
    });

    Route::prefix('/veiculos')->group(function () {
        Route::get('/', [VeiculoController::class, 'index']);
        Route::get('/{id}', [VeiculoController::class, 'show']);
        Route::post('/', [VeiculoController::class, 'store']);
        Route::patch('/{id}', [VeiculoController::class, 'update']);
        Route::delete('/{id}', [VeiculoController::class, 'destroy']);
        Route::get('/search/{nome}', [VeiculoController::class, 'search']);
    });

    Route::prefix('/reservas')->group(function () {
        Route::get('/', [ReservaController::class, 'index']);
        Route::get('/usuariosDisponiveis', [ReservaController::class, 'getUsuariosDisponiveis']);
        Route::post('/calcularPreco', [ReservaController::class, 'calcularPrecoTotal']);
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
        Route::get('/search/{nome}', [CategoriaController::class, 'search']);
    });
//});
