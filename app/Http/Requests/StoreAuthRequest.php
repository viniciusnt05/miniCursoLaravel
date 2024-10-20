<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthRequest extends FormRequest
{
    /**
     * Determine se o usuário está autorizado a fazer esta requisição.
     */
    public function authorize(): bool
    {
        return true; // Permite que todos os usuários possam fazer esta requisição
    }

    /**
     * Regras de validação que se aplicam à requisição.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email', // O email é obrigatório e deve ser válido
            'senha' => 'required|string|min:4', // A senha é obrigatória e deve ter no mínimo 4 caracteres
        ];
    }

    /**
     * Mensagens de erro personalizadas para as regras de validação.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo deve ser um endereço de email válido.',
            'senha.required' => 'O campo senha é obrigatório.',
            'senha.min' => 'A senha deve ter pelo menos 4 caracteres.',
        ];
    }
}
