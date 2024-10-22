<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/login', function () {
    return view('login.index');
})->name('login');

Route::get('/login/entrar', function () {
    return view('login.entrar');
});

// Rotas protegidas pelo middleware 'auth:sanctum'
//Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/home', function () {
        return view('home.index');
    });

    Route::get('/admin', function () {
        return view('admin.index');
    });

    Route::get('/veiculos', function () {
        return view('admin.veiculos');
    });

    Route::get('/categorias', function () {
        return view('admin.categorias');
    });

    Route::get('/equipe', function () {
        return view('admin.equipe');
    });

    Route::get('/reservas', function () {
        return view('admin.reservas');
    });


//});

Route::get('/veiculo/detalhes', function () {
    return view('rent.carro');
});
