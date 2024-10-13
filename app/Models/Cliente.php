<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'endereco',
        'telefone',
    ];

    // Relacionamento com as reservas (um cliente pode ter muitas reservas)
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_cliente');
    }
}
