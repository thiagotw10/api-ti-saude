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
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
{
    public function listar(PacientePaginacaoValidation $request)
    {
        $registrosPorPagina = $request->registro_por_pagina;
        $pacientes = Paciente::paginate($registrosPorPagina);
        foreach ($pacientes as $paciente) {
            $vinculo = Vinculo::where('paciente_id', $paciente->pac_codigo)->first();
            if ($vinculo) {
                $paciente->vinculo_codigo = $vinculo->vinc_codigo;
            }
        }

        return response($pacientes, 200);
    }

    public function cadastrar(PacienteValidation $request)
    {
        $paciente = Paciente::create([
            'pac_nome' => $request->pac_nome,
            'pac_dataNascimento' => $request->pac_dataNascimento,
            'pac_telefone' => $request->pac_telefone
        ]);

        if ($request->plano_saude) {
            Vinculo::create([
                'paciente_id' => $paciente->pac_codigo,
                'plano_saude_id' => $request->plano_saude,
                'nr_contrato' => DB::raw('CONCAT("CON-", LPAD(RAND() * 1000000, 6, "0"))')
            ]);
        }

        return response(['paciente' => $paciente], 201);
    }

    public function buscarPaciente($id)
    {

        $paciente = Paciente::where('pac_codigo', $id)->first();
        $vinculo = Vinculo::where('paciente_id', $paciente->pac_codigo)->first();
        if ($vinculo) {
            $paciente->plano_codigo = $vinculo->plano_saude_id;
        }

        if (!$paciente) {
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

        if ($request->plano_saude) {
            $vinculo = Vinculo::where('paciente_id', $id)->first();
            if ($vinculo) {
                $vinculo->update([
                    'paciente_id' => $paciente->pac_codigo,
                    'plano_saude_id' => $request->plano_saude,
                    'nr_contrato' => $vinculo->nr_contrato
                ]);
            } else {
                Vinculo::create([
                    'paciente_id' => $paciente->pac_codigo,
                    'plano_saude_id' => $request->plano_saude,
                    'nr_contrato' => DB::raw('CONCAT("CON-", LPAD(RAND() * 1000000, 6, "0"))')
                ]);
            }
        }

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
