<?php

use App\Http\Controllers\RoutesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home.index');
});

Route::get('/login', function () {
    return view('login.index');
});

Route::get('/login/entrar', function () {
    return view('login.entrar');
});

Route::get('/admin', function () {
    return view('admin.index');
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

Route::get('/veiculos', function () {
    return view('admin.veiculos');
});

Route::get('/veiculo/detalhes', function () {
    return view('rent.carro');
});
