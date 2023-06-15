<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanosaudeValidation;
use App\Models\PlanoSaude;
use Illuminate\Http\Request;

class PlanoSaudeController extends Controller
{
    public function listar(Request $request)
    {
        $registrosPorPagina = $request->registro_por_pagina;
        $PlanoSaudes = PlanoSaude::paginate($registrosPorPagina);

        return response($PlanoSaudes, 200);
    }

    public function cadastrar(PlanosaudeValidation $request)
    {
        $PlanoSaude = PlanoSaude::create([
            'plano_descricao' => $request->plano_descricao,
            'plano_telefone' => $request->plano_telefone,
        ]);

        return response(['PlanoSaude' => $PlanoSaude], 201);
    }

    public function buscarPlanoSaude($id)
    {

        $PlanoSaude = PlanoSaude::where('plano_codigo', $id)->first();

        if (!$PlanoSaude) {
            return response(['status' => 'PlanoSaude não encontrado.'], 404);
        }

        return response($PlanoSaude, 200);
    }

    public function editar(Request $request, $id)
    {

        $PlanoSaude = PlanoSaude::where('plano_codigo', $id)->first();
        if (!$PlanoSaude) {
            return response(['status' => 'PlanoSaude não encontrado.'], 404);
        }

        $PlanoSaude->update([
            'plano_descricao' => $request->plano_descricao ? $request->plano_descricao : $PlanoSaude->plano_descricao,
            'plano_telefone' => $request->plano_telefone ?  $request->plano_telefone :  $PlanoSaude->plano_telefone,
        ]);

        return response($PlanoSaude, 200);
    }

    public function deletar($id)
    {
        $PlanoSaude =  PlanoSaude::where('plano_codigo', $id)->first();

        if (!$PlanoSaude) {
            return response(['status' => 'PlanoSaude não encontrado nos registros.'], 404);
        }
        $PlanoSaude->delete();

        return response(null, 204);
    }
}
