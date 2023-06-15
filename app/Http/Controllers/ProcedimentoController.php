<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcedimentoValidation;
use App\Models\Especialidade;
use App\Models\Procedimento;
use Illuminate\Http\Request;

class ProcedimentoController extends Controller
{
    public function listar(Request $request)
    {
        $registrosPorPagina = $request->registro_por_pagina;
        $medicos = Procedimento::paginate($registrosPorPagina);

        return response($medicos, 200);
    }

    public function cadastrar(ProcedimentoValidation $request)
    {
        $procedimento = Procedimento::create([
            'proc_nome' => $request->proc_nome,
            'proc_valor' => $request->proc_valor,
        ]);

        return response($procedimento, 201);
    }

    public function buscarProcedimento($id)
    {

        $procedimento = Procedimento::where('proc_codigo', $id)->first();

        if (!$procedimento) {
            return response(['status' => 'Procedimento não encontrado.'], 404);
        }

        return response($procedimento, 200);
    }

    public function editar(Request $request, $id)
    {
        $procedimento = Procedimento::where('proc_codigo', $id)->first();

        if (!$procedimento) {
            return response(['status' => 'Procedimento não encontrado.'], 404);
        }

        $procedimento->update([
            'proc_nome' => $request->proc_nome ? $request->proc_nome : $procedimento->proc_nome,
            'proc_valor' => $request->proc_valor ?  $request->proc_valor : $procedimento->proc_valor
        ]);

        return response($procedimento, 200);
    }

    public function deletar($id)
    {
        $procedimento = Procedimento::where('proc_codigo', $id)->first();
        if (!$procedimento) {
            return response(['status' => 'Procedimento não encontrado nos registros.'], 404);
        }

        $procedimento->delete();

        return response(['status' => 'Procedimento deletado com sucesso.'], 200);
    }
}
