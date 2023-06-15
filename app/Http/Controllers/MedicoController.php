<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicoValidation;
use App\Http\Requests\PacientePaginacaoValidation;
use App\Models\Especialidade;
use App\Models\Medico;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MedicoController extends Controller
{

    public function listar(PacientePaginacaoValidation $request)
    {
        $registrosPorPagina = $request->registro_por_pagina;
        $medicos = Medico::with('especialidade')->paginate($registrosPorPagina);

        return response($medicos, 200);
    }

    public function cadastrar(MedicoValidation $request)
    {

        try {
            $medico = Medico::create([
                'med_nome' => $request->med_nome,
                'med_CRM' => $request->med_CRM,
                'med_espec' => $request->med_espec,
            ]);

            if (!$medico) {
                return response(['error' => 'Especialidade não existe'], 403);
            }
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode === 1452) {
                // Lidar com a violação de chave estrangeira
                return response(['status' => 'Não foi possível adicionar o vínculo devido a uma violação de chave estrangeira.'], 422);
            }

            // Lidar com outros erros ou retornar uma resposta genérica
            return response(['status' => 'Ocorreu um erro durante a criação do vínculo.'], 500);
        }

        return response(['medico' => $medico], 201);
    }


    public function buscarMedico($id)
    {

        $medico = Medico::with('especialidade')->where('med_codigo', $id)->first();

        if (!$medico) {
            return response(['status' => 'Médico não encontrado.'], 404);
        }

        return response($medico, 200);
    }

    public function editar(Request $request, $id)
    {
        $medico = Medico::where('med_codigo', $id)->first();

        if (!$medico) {
            return response(['status' => 'Médico não encontrado.'], 404);
        }

        $medico->update([
            'med_nome' => $request->med_nome ? $request->med_nome : $medico->med_nome,
            'med_CRM' => $request->med_CRM ?  $request->med_CRM : $medico->med_CRM,
            'med_espec' => $request->med_espec ?  $request->med_espec : $medico->med_espec
        ]);

        return response($medico, 200);
    }

    public function deletar($id)
    {
        $medico =  Medico::where('med_codigo', $id)->first();
        if (!$medico) {
            return response(['status' => 'Médico não encontrado nos registros.'], 404);
        }

        $medico->delete();

        return response(['status' => 'Médico deletado com sucesso.'], 200);
    }
}
