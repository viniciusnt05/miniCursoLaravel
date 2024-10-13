<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'id_cliente',
        'id_veiculo',
        'data_retirada',
        'data_devolucao_prevista',
        'status',
        'valor_total',
    ];

    // Relacionamento com o cliente (uma reserva pertence a um cliente)
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Relacionamento com o veículo (uma reserva pertence a um veículo)
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'id_veiculo');
    }
}
