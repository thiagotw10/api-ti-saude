<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeguimentoValidation;
use App\Models\SeguimentoProdutosPainel;
use Illuminate\Http\Request;

class SeguimentoProdutosPainelController extends Controller
{
    public function listarSeguimentos(Request $request){

        $seguimento = SeguimentoProdutosPainel::with('produtos')->paginate($request->limit);

        return response($seguimento, 200);
    }

    public function criarSeguimentos(SeguimentoValidation $request){

       $seguimento = SeguimentoProdutosPainel::create([
            "nome_seguimento" => $request->nome_seguimento,
		    "nome_imagem" => $request->nome_imagem,
		    "url_imagem" => $request->url_imagem
        ]);

        return response($seguimento, 201);
    }
}
