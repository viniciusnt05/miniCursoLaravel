<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    // Lista todos os veículos
    public function index()
    {
        $veiculos = Veiculo::with('categoria')->get();
        return response()->json($veiculos);
    }

    // Mostra um veículo específico por ID
    public function show($id)
    {
        $veiculo = Veiculo::with('categoria')->find($id);
        if (!$veiculo) {
            return response()->json(['message' => 'Veículo não encontrado'], 404);
        }
        return response()->json($veiculo);
    }

    // Cria um novo veículo
    public function store(Request $request)
    {
        // Valida os dados do veículo
        $request->validate([
            'id_categoria' => 'required|exists:categorias,id',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'ano_fabricacao' => 'required|integer|min:1886', // Desde a invenção do carro
            'placa' => 'required|string|max:10|unique:veiculos,placa',
            'status' => 'required|in:disponível,alugado,em manutenção',
        ]);

        // Cria e salva o veículo no banco
        $veiculo = Veiculo::create($request->all());
        return response()->json($veiculo, 201);
    }

    // Atualiza um veículo existente
    public function update(Request $request, $id)
    {
        $veiculo = Veiculo::find($id);
        if (!$veiculo) {
            return response()->json(['message' => 'Veículo não encontrado'], 404);
        }

        // Valida os dados de atualização
        $request->validate([
            'id_categoria' => 'exists:categorias,id',
            'marca' => 'string|max:255',
            'modelo' => 'string|max:255',
            'ano_fabricacao' => 'integer|min:1886',
            'placa' => 'string|max:10|unique:veiculos,placa,' . $id,
            'status' => 'in:disponível,alugado,em manutenção',
        ]);

        // Atualiza os dados do veículo
        $veiculo->update($request->all());
        return response()->json($veiculo, 200);
    }

    // Deleta um veículo
    public function destroy($id)
    {
        $veiculo = Veiculo::find($id);
        if (!$veiculo) {
            return response()->json(['message' => 'Veículo não encontrado'], 404);
        }

        $veiculo->delete();
        return response()->json(['message' => 'Veículo deletado com sucesso'], 200);
    }
}
