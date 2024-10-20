<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateVeiculoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Permitir o uso da request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'id_categoria' => 'required|exists:categorias,id',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'ano_fabricacao' => 'required|integer|min:1886',
            'placa' => 'required|string|max:10|unique:veiculos,placa',
            'status' => 'required|in:disponível,alugado,em manutenção',
            'valor' => 'required|numeric|min:0', // Adicionando validação para o campo 'valor'
//            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Campo de imagem
        ];

        // Regras de validação diferentes para a atualização
        if ($this->isMethod('patch')) {
            $rules['placa'] = 'string|max:10|unique:veiculos,placa,' . $this->route('id');
            $rules['img'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'; // Campo de imagem para a atualização
        }

        return $rules;
    }
}
