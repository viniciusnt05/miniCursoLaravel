<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ReservaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'cliente' => [
                'id_cliente' => $this->cliente->id,
                'nome' => $this->cliente->nome,
            ],
            'veiculo' => [
                'id_veiculo' => $this->veiculo->id,
                'modelo' => $this->veiculo->modelo,
                'placa' => $this->veiculo->placa,
            ],
            'data_retirada' => $this->data_retirada,
            'data_devolucao_prevista' => $this->data_devolucao_prevista,
            'qtd_dias' => $this->qtd_dias,
            'valor_total' => $this->valor_total,
            'status' => $this->status,
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->format('d/m/Y H:i:s') : null,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format('d/m/Y H:i:s') : null,
        ];
    }
}
