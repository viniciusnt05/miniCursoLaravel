<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUsuarioRequest; // Importa a classe de requisição
use App\Models\Usuario; // Importa o modelo Usuario
use Illuminate\Support\Facades\Hash; // Importa a facade Hash para criptografar senhas

class UsuarioController extends Controller
{
    // Lista todos os clientes
    public function index()
    {
        // Recupera todos os usuários do banco de dados
        $clientes = Usuario::all();

        $numero_total = $clientes->count();

        // Retorna a lista de clientes em formato JSON
        return response()->json([
            'usuarios' => $clientes,
            'numero_total' => $numero_total,
        ]);
    }

    // Mostra um cliente específico por ID
    public function show($id)
    {
        // Busca o cliente pelo ID
        $cliente = Usuario::find($id);

        // Verifica se o cliente foi encontrado
        if (!$cliente) {
            // Retorna um erro 404 caso o cliente não seja encontrado
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        // Retorna o cliente em formato JSON
        return response()->json($cliente);
    }

    // Cria um novo cliente
    public function store(StoreUpdateUsuarioRequest $request)
    {
        try {
            $usuario = Usuario::create($request->all());

            // Salvando usuário no banco de dados
            $usuario->save();

            // Redireciona para a página de login com uma mensagem de sucesso
            return response()->json(['message' => 'Usuário cadastrado com sucesso!'], 201);
        } catch (\Exception $e) {
            // Retorna uma resposta JSON com o erro caso ocorra uma exceção
            return response()->json(['error' => 'Erro ao cadastrar o usuário: ' . $e->getMessage()], 500);
        }
    }

    // Atualiza um cliente existente
    public function update(StoreUpdateUsuarioRequest $request, $id)
    {
        // Busca o cliente pelo ID
        $cliente = Usuario::find($id);

        // Verifica se o cliente foi encontrado
        if (!$cliente) {
            // Retorna um erro 404 caso o cliente não seja encontrado
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        try {
            // Atualiza os dados do cliente com dados validados
            $cliente->nome = $request->nome; // Atribui o nome do usuário
            $cliente->cpf = preg_replace('/\D/', '', $request->cpf); // Remove a máscara do CPF
            $cliente->email = $request->email; // Atribui o email
            $cliente->senha = Hash::make($request->senha); // Criptografa a senha
            $cliente->data_nascimento = $request->data_nascimento; // Atribui a data de nascimento
            $cliente->endereco = $request->endereco; // Atribui o endereço
            $cliente->telefone = $request->telefone; // Atribui o telefone

            // Salvando as alterações no banco de dados
            $cliente->save();

            // Retorna o cliente atualizado em formato JSON
            return response()->json(['message' => 'Cliente atualizado com sucesso!', 'cliente' => $cliente], 200);
        } catch (\Exception $e) {
            // Retorna uma resposta JSON com o erro caso ocorra uma exceção
            return response()->json(['error' => 'Erro ao atualizar o usuário: ' . $e->getMessage()], 500);
        }
    }

    // Deleta um cliente
    public function destroy($id)
    {
        // Busca o cliente pelo ID
        $cliente = Usuario::find($id);

        // Verifica se o cliente foi encontrado
        if (!$cliente) {
            // Retorna um erro 404 caso o cliente não seja encontrado
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        // Deleta o cliente do banco de dados
        $cliente->delete();

        // Retorna uma mensagem de sucesso em formato JSON
        return response()->json(['message' => 'Cliente deletado com sucesso'], 200);
    }

}
