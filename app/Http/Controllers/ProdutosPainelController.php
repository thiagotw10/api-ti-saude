<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutosValidation;
use App\Models\CaracteristicaProdutosPainel;
use App\Models\EspecificacaoProdutosPainel;
use App\Models\ImagensProdutosPainel;
use App\Models\InformacoesAdicionaisProdutosPainel;
use App\Models\produtosPainel;
use Illuminate\Http\Request;

class ProdutosPainelController extends Controller
{
    public function listarProdutos(Request $request)
    {
        $produtos = produtosPainel::with('informacoes', 'caracteristicas', 'especificacoes', 'imagens')->paginate($request->limit);

        return response($produtos, 200);
    }

    public function criarProdutos(ProdutosValidation $request)
    {
        $informacoes = null;
        $caracteristica = null;
        $especificao = null;
        $imagem = null;
        $informacoesArray = [];
        $caracteristicaArray = [];
        $especificaoArray = [];
        $imagemArray = [];

        $produto = produtosPainel::create([
            "seguimento_id" => $request->seguimento_id,
            "nome_do_produto" => $request->nome_do_produto,
            "descricao_do_produto" => $request->descricao_do_produto,
            "preco_do_produto" => $request->preco_do_produto,
            "preco_do_produto_com_desconto" => $request->preco_do_produto_com_desconto,
            "unidades_do_produto" => $request->unidades_do_produto,
            "posicao_do_produto" => $request->posicao_do_produto
        ]);

        if ($request->especificacao_do_produto) {
            foreach ($request->especificacao_do_produto as $espe) {
                $especificao = EspecificacaoProdutosPainel::create([
                    'produto_id' => $produto->id,
                    'especificacao_do_produto' => $espe
                ]);
                $especificaoArray[] = $especificao;
            }
        }

        if ($request->caracteristica_do_produto) {
            foreach ($request->caracteristica_do_produto as $caracter) {
                $caracteristica = CaracteristicaProdutosPainel::create([
                    'produto_id' => $produto->id,
                    'caracteristica_do_produto' => $caracter
                ]);

                $caracteristicaArray[] = $caracteristica;
            }
        }

        if ($request->informacoes_adicionais) {
            foreach ($request->informacoes_adicionais as $info) {
                $informacoes = InformacoesAdicionaisProdutosPainel::create([
                    'produto_id' => $produto->id,
                    'informacoes_adicionais_do_produto' => $info
                ]);

                $informacoesArray[] = $informacoes;
            }
        }

        if($request->imagens_do_produto){
            foreach ($request->imagens_do_produto as $img) {
                $imagem = ImagensProdutosPainel::create([
                    'produto_id' => $produto->id,
                    'nome_da_imagem' => $img,
                    'url_imagem' => $img
                ]);

                $imagemArray[] = $imagem;
            }
        }

        return response(['produto' => $produto, 'especificacao_do_produto' => $especificaoArray, 'caracteristica_do_produto' => $caracteristicaArray, 'informacoes_adicionais' => $informacoesArray, 'imagens_do_produto' => $imagemArray ], 201);
    }
}
