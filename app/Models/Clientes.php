<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Clientes extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cpf',
        'endereco',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'numero_casa',
        'senha',
        'status',
        'cep'
    ];

    protected $hidden = [
        'senha',
        'created_at',
        'updated_at',
    ];
}
