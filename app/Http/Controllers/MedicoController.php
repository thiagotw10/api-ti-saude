<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicoValidation;
use App\Http\Requests\PacientePaginacaoValidation;
use App\Models\Especialidade;
use App\Models\Medico;
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

        $existeEspecialidade = Especialidade::where('espec_nome', 'LIKE', '%' . $request->especialidade['espec_nome'] . '%')->get();
        $especialidade = null;
        if (!isset($existeEspecialidade[0])) {
            $especCodigo = md5(uniqid(rand(), true));
            $especialidade =  Especialidade::create([
                'espec_codigo' => $especCodigo,
                'espec_nome' => $request->especialidade['espec_nome']
            ]);
        } else {
            $especialidadeId = $existeEspecialidade[0]->id;
            $especialidadeExiste = $existeEspecialidade[0];
        }


        $medCodigo = md5(uniqid(rand(), true));
        $medico = Medico::create([
            'med_codigo' => $medCodigo,
            'espec_id' => $especialidade ? $especialidade->id : $especialidadeId,
            'med_nome' => $request->medico['med_nome'],
            'med_CRM' => $request->medico['med_CRM'],
        ]);

        return response(['medico' => $medico, 'especialidade' => $especialidade ? $especialidade : $especialidadeExiste ], 201);
    }


    public function buscarMedico($nome)
    {

        $medico = Medico::where('med_nome', 'LIKE', '%' . $nome . '%')->get();

        if (isset($medico[0]) == '') {
            return response(['status' => 'Médico não encontrado.'], 404);
        }

        return response($medico, 200);
    }

    public function editar(Request $request, $id)
    {
        $medico = Medico::find($id);

        if (!$medico) {
            return response(['status' => 'Médico não encontrado.'], 404);
        }

        $medico->update([
            'med_codigo' => $medico->pac_codigo,
            'espec_id' => $medico->espec_id,
            'med_nome' => $request->med_nome ? $request->med_nome : $medico->med_nome,
            'med_CRM' => $request->med_CRM ?  $request->med_CRM : $medico->med_CRM
        ]);

        return response($medico, 200);
    }

    public function deletar($id)
    {
        $medico =  Medico::where('med_codigo', $id)->get();
        $id = isset($medico[0]->id);
        if ($id) {
            $medicoDelete = Medico::find($medico[0]->id);
        } else {
            return response(['status' => 'Médico não encontrado nos registros.'], 404);
        }

        $medicoDelete->delete();

        return response(['status' => 'Médico deletado com sucesso.'], 200);
    }
}
