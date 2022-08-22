<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacoesAdicionaisProdutosPainel extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'produto_id',
        'informacoes_adicionais_do_produto'
    ];
}
