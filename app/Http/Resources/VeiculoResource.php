<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VeiculoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'categoria' => [
                'id' => $this->categoria->id ?? null,
                'nome' => $this->categoria->nome ?? null,
            ],
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'ano_fabricacao' => $this->ano_fabricacao,
            'imagem' => $this->img,
            'valor' => $this->valor,
            'placa' => $this->placa,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
