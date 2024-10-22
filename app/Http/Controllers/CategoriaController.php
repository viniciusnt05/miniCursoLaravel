<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        return Categoria::all();
    }

    public function store(Request $request)
    {
        $categoria = Categoria::create($request->all());
        return response()->json($categoria, 201);
    }

    public function show($id)
    {
        return Categoria::find($id);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());
        return response()->json($categoria, 200);
    }

    public function destroy($id)
    {
        Categoria::destroy($id);
        return response()->json(null, 204);
    }

    public function search($nome)
    {
        // Verifica se o nome foi passado e não está vazio
        if (empty($nome)) {
            return response()->json([], 200);
        }

        // Ajuste da consulta para considerar termos parciais
        $categorias = Categoria::where('nome', 'LIKE', '%' . $nome . '%')->get();

        // Retorna as categorias encontradas ou um array vazio
        return response()->json($categorias, 200);
    }

}

