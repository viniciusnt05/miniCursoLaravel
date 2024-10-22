<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUsuarioRequest extends FormRequest
{
    /**
     * Determine se o usuário está autorizado a fazer esta solicitação.
     */
    public function authorize(): bool
    {
        return true; // Permitir que todos os usuários façam essa requisição
    }

    /**
     * Obter as regras de validação que se aplicam à solicitação.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:usuarios,cpf',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|min:4',
            'data_nascimento' => 'required|date',
            'endereco' => 'nullable|string|max:255', // Endereço opcional
            'telefone' => 'nullable|string|max:15',  // Telefone opcional
//            'tipo_usuario' => 'required|string|max:50', // Tipo de usuário obrigatório
        ];
    }

    /**
     * Obter as mensagens de erro personalizadas para as regras de validação.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'senha.required' => 'A senha é obrigatória.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
//            'tipo_usuario.required' => 'O tipo de usuário é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.unique' => 'Este email já está cadastrado.',
        ];
    }
}
