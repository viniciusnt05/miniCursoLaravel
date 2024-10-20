<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Importa a classe Authenticatable
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'senha',
        'data_nascimento',
        'endereco',
        'telefone',
        'tipo_usuario',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_cliente');
    }

    // Renomeie a coluna de senha se ela for diferente de 'password'
    public function getAuthPassword()
    {
        return $this->senha;
    }
}


