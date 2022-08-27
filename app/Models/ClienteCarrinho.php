<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteCarrinho extends Model
{
    use HasFactory;

    protected $fillable = [
            'cliente_id',
			'produto_id',
			'nome_produto',
			'valor',
			'quantidade',
			'metedo_pagamento'
    ];
}
