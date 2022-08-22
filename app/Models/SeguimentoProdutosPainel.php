<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimentoProdutosPainel extends Model
{
    use HasFactory;

    protected $fillable = [
            "nome_seguimento",
		    "nome_imagem",
		    "url_imagem"
    ];

    public function produtos(){
        return $this->hasMany(produtosPainel::class, 'seguimento_id');
    }
}
