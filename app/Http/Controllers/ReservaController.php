<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Http\Requests\StoreUpdateReservaRequest;

class ReservaController extends Controller
{
    // Lista todas as reservas
    public function index()
    {
        $reservas = Reserva::with('usuario', 'veiculo')->get();
        return response()->json($reservas);
    }

    // Mostra uma reserva específica por ID
    public function show($id)
    {
        $reserva = Reserva::with('usuario', 'veiculo')->find($id);
        if (!$reserva) {
            return response()->json(['message' => 'Reserva não encontrada'], 404);
        }
        return response()->json($reserva);
    }

    // Cria uma nova reserva
    public function store(StoreUpdateReservaRequest $request)
    {
        // Cria uma nova reserva e atribui os campos
        $reserva = new Reserva;
        $reserva->id_cliente = $request->id_cliente;
        $reserva->id_veiculo = $request->id_veiculo;
        $reserva->data_retirada = $request->data_retirada;
        $reserva->data_devolucao_prevista = $request->data_devolucao_prevista;
        $reserva->status = $request->status;
        $reserva->valor_total = $request->valor_total;

        $reserva->save();

        // Retorna a resposta JSON
        return response()->json($reserva, 201);
    }

    // Atualiza uma reserva existente
    public function update(StoreUpdateReservaRequest $request, $id)
    {
        $reserva = Reserva::find($id);
        if (!$reserva) {
            return response()->json(['message' => 'Reserva não encontrada'], 404);
        }

        // Atualiza os dados da reserva
        $reserva->update($request->validated());
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
