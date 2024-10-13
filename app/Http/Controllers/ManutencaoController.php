<?php

namespace App\Http\Controllers;

use App\Models\Manutencao;
use Illuminate\Http\Request;

class ManutencaoController extends Controller
{
    // Lista todas as manutenções
    public function index()
    {
        $manutencoes = Manutencao::all();
        return response()->json($manutencoes);
    }

    // Mostra uma manutenção específica por ID
    public function show($id)
    {
        $manutencao = Manutencao::find($id);
        if (!$manutencao) {
            return response()->json(['message' => 'Manutenção não encontrada'], 404);
        }
        return response()->json($manutencao);
    }

    // Cria uma nova manutenção
    public function store(Request $request)
    {
        // Valida os dados da manutenção
        $request->validate([
            'id_veiculo' => 'required|exists:veiculos,id',
            'data' => 'required|date',
            'descricao' => 'required|string|max:255',
        ]);

        // Cria e salva a manutenção no banco
        $manutencao = Manutencao::create($request->all());
        return response()->json($manutencao, 201);
    }

    // Atualiza uma manutenção existente
    public function update(Request $request, $id)
    {
        $manutencao = Manutencao::find($id);
        if (!$manutencao) {
            return response()->json(['message' => 'Manutenção não encontrada'], 404);
        }

        // Valida os dados de atualização
        $request->validate([
            'id_veiculo' => 'exists:veiculos,id',
            'data' => 'date',
            'descricao' => 'string|max:255',
        ]);

        // Atualiza os dados da manutenção
        $manutencao->update($request->all());
        return response()->json($manutencao, 200);
    }

    // Deleta uma manutenção
    public function destroy($id)
    {
        $manutencao = Manutencao::find($id);
        if (!$manutencao) {
            return response()->json(['message' => 'Manutenção não encontrada'], 404);
        }

        $manutencao->delete();
        return response()->json(['message' => 'Manutenção deletada com sucesso'], 200);
    }
}
