<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produtosPainel extends Model
{
    use HasFactory;

    protected $fillable = [
        "seguimento_id",
		"nome_do_produto",
		"descricao_do_produto",
		"preco_do_produto",
		"preco_do_produto_com_desconto",
		"unidades_do_produto",
		"posicao_do_produto"
    ];

    public function informacoes(){
        return $this->hasMany(InformacoesAdicionaisProdutosPainel::class, 'produto_id');
    }

    public function caracteristicas(){
        return $this->hasMany(CaracteristicaProdutosPainel::class, 'produto_id');
    }

    public function especificacoes(){
        return $this->hasMany(EspecificacaoProdutosPainel::class, 'produto_id');
    }

    public function imagens(){
        return $this->hasMany(ImagensProdutosPainel::class, 'produto_id');
    }

}
