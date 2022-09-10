<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcedimentoValidation;
use App\Models\Especialidade;
use App\Models\Procedimento;
use Illuminate\Http\Request;

class ProcedimentoController extends Controller
{
    public function listar(Request $request){
        $registrosPorPagina = $request->registro_por_pagina;
        $medicos = Procedimento::with('especialidade')->paginate($registrosPorPagina);

        return response($medicos, 200);
    }

    public function cadastrar(ProcedimentoValidation $request){

        $especialidade = null;
        $espec = Especialidade::where('espec_codigo', $request->espec_codigo)->get();
        if(isset($espec[0]))
        $especialidade = Especialidade::find($espec[0]->id);

        if(!$especialidade){
            $especilidadeAll = Especialidade::all();
            return response(['especialidades' => $especilidadeAll], 400);
        }

        $procCodigo = md5(uniqid(rand(), true));
        $procedimento = Procedimento::create([
            'proc_codigo' => $procCodigo,
            'proc_nome' => $request->proc_nome,
            'proc_valor' => $request->proc_valor,
            'espec_id' => $espec[0]->id
        ]);

        return response($procedimento, 201);
    }

    public function buscarProcedimento($nome)
    {

        $procedimento = Procedimento::with('especialidade')->where('proc_nome', 'LIKE', '%' . $nome . '%')->get();

        if (isset($procedimento[0]) == '') {
            return response(['status' => 'Procedimento não encontrado.'], 404);
        }

        return response($procedimento, 200);
    }

    public function editar(Request $request, $id)
    {
        $procedimento = Procedimento::find($id);

        if (!$procedimento) {
            return response(['status' => 'Procedimento não encontrado.'], 404);
        }

        $procedimento->update([
            'proc_codigo' => $procedimento->proc_codigo,
            'espec_id' => $procedimento->espec_id,
            'proc_nome' => $request->proc_nome ? $request->proc_nome : $procedimento->proc_nome,
            'proc_valor' => $request->proc_valor ?  $request->proc_valor : $procedimento->proc_valor
        ]);

        return response($procedimento, 200);
    }

    public function deletar($id)
    {
        $procedimento =  Procedimento::where('proc_codigo', $id)->get();
        $id = isset($procedimento[0]->id);
        if ($id) {
            $procedimentoDelete = Procedimento::find($procedimento[0]->id);
        } else {
            return response(['status' => 'Procedimento não encontrado nos registros.'], 404);
        }

        $procedimentoDelete->delete();

        return response(['status' => 'Procedimento deletado com sucesso.'], 200);
    }
}
