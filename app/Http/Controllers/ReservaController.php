<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    // Lista todas as reservas
    public function index()
    {
        $reservas = Reserva::with('cliente', 'veiculo')->get();
        return response()->json($reservas);
    }

    // Mostra uma reserva específica por ID
    public function show($id)
    {
        $reserva = Reserva::with('cliente', 'veiculo')->find($id);
        if (!$reserva) {
            return response()->json(['message' => 'Reserva não encontrada'], 404);
        }
        return response()->json($reserva);
    }

    // Cria uma nova reserva
    public function store(Request $request)
    {
        // Valida os dados da reserva
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'id_veiculo' => 'required|exists:veiculos,id',
            'data_retirada' => 'required|date',
            'data_devolucao_prevista' => 'required|date|after_or_equal:data_retirada',
            'status' => 'required|in:confirmada,cancelada,concluída',
            'valor_total' => 'required|numeric|min:0',
        ]);

        // Cria e salva a reserva no banco
        $reserva = Reserva::create($request->all());
        return response()->json($reserva, 201);
    }

    // Atualiza uma reserva existente
    public function update(Request $request, $id)
    {
        $reserva = Reserva::find($id);
        if (!$reserva) {
            return response()->json(['message' => 'Reserva não encontrada'], 404);
        }

        // Valida os dados de atualização
        $request->validate([
            'id_cliente' => 'exists:clientes,id',
            'id_veiculo' => 'exists:veiculos,id',
            'data_retirada' => 'date',
            'data_devolucao_prevista' => 'date|after_or_equal:data_retirada',
            'status' => 'in:confirmada,cancelada,concluída',
            'valor_total' => 'numeric|min:0',
        ]);

        // Atualiza os dados da reserva
        $reserva->update($request->all());
        return response()->json($reserva, 200);
    }

    // Deleta uma reserva
    public function destroy($id)
    {
        $reserva = Reserva::find($id);
        if (!$reserva) {
            return response()->json(['message' => 'Reserva não encontrada'], 404);
        }

        $reserva->delete();
        return response()->json(['message' => 'Reserva deletada com sucesso'], 200);
    }
}
