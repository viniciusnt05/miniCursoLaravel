<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateReservaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // Validações para a criação e atualização de reservas
        return [
            'id_cliente' => 'required|exists:usuarios,id',
            'id_veiculo' => 'required|exists:veiculos,id',
            'data_retirada' => 'required|date',
            'data_devolucao_prevista' => 'required|date|after_or_equal:data_retirada',
            'status' => 'required|in:ativa,confirmada,cancelada,concluída',
            'valor_total' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'id_cliente.required' => 'O campo cliente é obrigatório.',
            'id_cliente.exists' => 'O cliente selecionado não existe.',
            'id_veiculo.required' => 'O campo veículo é obrigatório.',
            'id_veiculo.exists' => 'O veículo selecionado não existe.',
            'data_retirada.required' => 'O campo data de retirada é obrigatório.',
            'data_devolucao_prevista.required' => 'O campo data de devolução prevista é obrigatório.',
            'data_devolucao_prevista.after_or_equal' => 'A data de devolução prevista deve ser igual ou posterior à data de retirada.',
            'status.required' => 'O campo status é obrigatório.',
            'status.in' => 'O status deve ser um dos seguintes: ativa, confirmada, cancelada ou concluída.',
            'valor_total.required' => 'O campo valor total é obrigatório.',
            'valor_total.numeric' => 'O valor total deve ser numérico.',
            'valor_total.min' => 'O valor total deve ser maior ou igual a 0.',
        ];
    }
}
