<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacoes extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'valor',
        'url_pdf',
        'url_img',
        'status',
        'retorno_transacao',
        'metedo_pagamento',
        'data_pagamento',
    ];
}
