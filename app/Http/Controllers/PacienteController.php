<?php

namespace App\Http\Controllers;

use App\Models\Vinculo;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\PlanoSaude;
use Illuminate\Http\Request;
use App\Models\ConsultaMarcadas;
use App\Http\Requests\PacienteValidation;
use App\Http\Requests\PacientePaginacaoValidation;

class PacienteController extends Controller
{
    public function listar(PacientePaginacaoValidation $request)
    {
        $registrosPorPagina = $request->registro_por_pagina;
        $pacientes = Paciente::paginate($registrosPorPagina);

        return response($pacientes, 200);
    }

    public function cadastrar(PacienteValidation $request)
    {
        $paciente = Paciente::create([
            'pac_nome' => $request->pac_nome,
            'pac_dataNascimento' => $request->pac_dataNascimento,
            'pac_telefone' => $request->pac_telefone
        ]);

        return response(['paciente' => $paciente], 201);
    }

    public function buscarPaciente($nome)
    {

        $paciente = Paciente::where('pac_nome', 'LIKE', '%' . $nome . '%')->get();

        if (isset($paciente[0]) == '') {
            return response(['status' => 'Paciente não encontrado.'], 404);
        }

        return response($paciente, 200);
    }

    public function editar(Request $request, $id)
    {

        $paciente = Paciente::where('pac_codigo', $id)->first();
        if (!$paciente) {
            return response(['status' => 'Paciente não encontrado.'], 404);
        }

        $paciente->update([
            'pac_nome' => $request->pac_nome ? $request->pac_nome : $paciente->pac_nome,
            'pac_telefone' => $request->pac_telefone ?  $request->pac_telefone :  $paciente->pac_telefone,
            'pac_dataNascimento' => $request->pac_dataNascimento ?  $request->pac_dataNascimento :  $paciente->pac_dataNascimento
        ]);

        return response($paciente, 200);
    }

    public function deletar($id)
    {
        $paciente =  Paciente::where('pac_codigo', $id)->first();
        if (!$paciente) {
            return response(['status' => 'Paciente não encontrado nos registros.'], 404);
        }
        $paciente->delete();

        return response(null, 204);
    }
}
