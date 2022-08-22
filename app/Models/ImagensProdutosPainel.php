<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagensProdutosPainel extends Model
{
    use HasFactory;

    protected $fillable = [
        'produto_id',
        'nome_da_imagem',
        'url_imagem'
    ];
}
