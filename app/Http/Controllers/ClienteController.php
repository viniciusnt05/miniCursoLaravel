<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Lista todos os clientes
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    // Mostra um cliente específico por ID
    public function show($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }
        return response()->json($cliente);
    }

    // Cria um novo cliente
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:clientes',
            'data_nascimento' => 'required|date',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
        ]);

        $cliente = Cliente::create($request->all());
        return response()->json($cliente, 201);
    }

    // Atualiza um cliente existente
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        // Valida os dados de atualização
        $request->validate([
            'nome_completo' => 'string|max:255',
            'cpf' => 'string|max:14|unique:clientes,cpf,' . $id,
            'data_nascimento' => 'date',
            'endereco' => 'string|max:255',
            'telefone' => 'string|max:15',
        ]);

        // Atualiza os dados do cliente
        $cliente->update($request->all());
        return response()->json($cliente, 200);
    }

    // Deleta um cliente
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        $cliente->delete();
        return response()->json(['message' => 'Cliente deletado com sucesso'], 200);
    }
}
