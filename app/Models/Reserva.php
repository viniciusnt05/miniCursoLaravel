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
        'qtd_dias',
        'valor_total',
        'status'
    ];

    // Relacionamento com o cliente (uma reserva pertence a um cliente)
    public function cliente()
    {
        return $this->belongsTo(Usuario::class, 'id_cliente');
    }

    // Relacionamento com o veículo (uma reserva pertence a um veículo)
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'id_veiculo');
    }
}
