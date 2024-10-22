<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Http\Requests\StoreUpdateReservaRequest;
use App\Models\Usuario;
use App\Models\Veiculo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    // Lista todas as reservas
    public function index()
    {
        $reservas = Reserva::with('usuario', 'veiculo')->get();

        // Adiciona o número total de reservas
        $numero_total = $reservas->count();

        return response()->json([
            'reservas' => $reservas,
            'numero_total' => $numero_total,
        ]);
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
        $reserva = Reserva::create($request->all());

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

    public function getUsuariosDisponiveis()
    {
        // Busca os IDs dos usuários que estão em reservas confirmadas
        $usuariosReservados = Reserva::where('status', 'confirmada')->pluck('id_cliente');

        // Busca os usuários que não estão em reservas confirmadas
        $usuariosDisponiveis = Usuario::whereNotIn('id', $usuariosReservados)->get();

        return response()->json($usuariosDisponiveis);
    }

    public function calcularPrecoTotal(Request $request)
    {
        // Validações básicas
        $request->validate([
            'id_veiculo' => 'required|exists:veiculos,id',
            'data_retirada' => 'required|date',
            'data_devolucao_prevista' => 'required|date|after_or_equal:data_retirada',
        ]);

        // Obtém os dados do veículo
        $veiculo = Veiculo::findOrFail($request->id_veiculo);

        // Calcula a quantidade de dias entre retirada e devolução
        $dataRetirada = Carbon::parse($request->data_retirada);
        $dataDevolucaoPrevista = Carbon::parse($request->data_devolucao_prevista);
        $qtdDias = $dataDevolucaoPrevista->diffInDays($dataRetirada) + 1; // Inclui o dia de retirada

        // Calcula o preço total
        $precoTotal = $qtdDias * $veiculo->valor;

        // Retorna o preço total em um JSON
        return response()->json([
            'preco_total' => $precoTotal,
            'qtd_dias' => $qtdDias,
        ], 200);
    }

}
