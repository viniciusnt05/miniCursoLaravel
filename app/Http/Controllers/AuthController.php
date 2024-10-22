<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Função de login
    public function login(StoreAuthRequest $request)
    {
        // Dados validados
        $credentials = $request->validated();

        // Busca o usuário pelo email
        $usuario = Usuario::where('email', $credentials['email'])->first();

        // Verifica se o usuário foi encontrado e a senha está correta
        if ($usuario && Hash::check($credentials['senha'], $usuario->senha)) {
            // Apaga todos os tokens antigos do usuário
            $usuario->tokens()->delete();

            // Gera um novo token de acesso usando Sanctum
            $token = $usuario->createToken('auth_token')->plainTextToken;

            // Retorna uma resposta com o novo token
            return response()->json([
                'message' => 'Login realizado com sucesso!',
                'token' => $token,
                'usuario' => [
                    'id' => $usuario->id,
                    'nome' => $usuario->nome,
                    'email' => $usuario->email,
                    'is_admin' => $usuario->tipo_usuario == 'admin' ? true : false,
                ],
            ], 200);
        }

        // Retorna um erro de autenticação se as credenciais forem inválidas
        return response()->json(['error' => 'Credenciais inválidas. Por favor, tente novamente.'], 401);
    }

    // Função de logout
    public function logout(Request $request)
    {
        // Verifica se o usuário está autenticado
        $usuario = $request->user();

        if ($usuario) {
            // Revoga o token atual do usuário
            $usuario->currentAccessToken()->delete();

            return response()->json(['message' => 'Logout realizado com sucesso!'], 200);
        }

        // Retorna um erro se o usuário não estiver autenticado
        return response()->json(['error' => 'Usuário não autenticado.'], 401);
    }
}
