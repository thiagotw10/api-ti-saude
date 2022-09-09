<?php

namespace App\Http\Controllers;

use App\Http\Requests\PacientePaginacaoValidation;
use App\Http\Requests\PacienteValidation;
use App\Models\Paciente;
use App\Models\PlanoSaude;
use App\Models\Vinculo;
use Illuminate\Http\Request;

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
        $pacCodigo = md5(uniqid(rand(), true));
        $paciente = Paciente::create([
            'pac_codigo' => $pacCodigo,
            'pac_nome' => $request->paciente['pac_nome'],
            'pac_dataNascimento' => $request->paciente['pac_dataNascimento'],
            'pac_telefone' => $request->paciente['pac_telefone']
        ]);

        $planosArrayResponse = [];
        $vinculoArrayResponse = [];
        if($request->planos_de_saude){
            foreach ($request->planos_de_saude as $plano) {

                $planoCodigo = md5(uniqid(rand(), true));
                $planoSaude = PlanoSaude::create([
                    'plano_codigo' => $planoCodigo,
                    'plano_descricao' => $plano['plano_descricao'],
                    'plano_telefone' => $plano['plano_telefone']
                ]);
                array_push($planosArrayResponse, $planoSaude);

                $nrContrato = md5(uniqid(rand(), true));
                $vinculo = Vinculo::create([
                    'paciente_id' => $paciente->id,
                    'plano_saude_id' => $planoSaude->id,
                    'nr_contrato' => $nrContrato
                ]);
                array_push($vinculoArrayResponse, $vinculo);
            }
        }


        $pacienteToken = Paciente::where('pac_codigo', $paciente->pac_codigo)->first();

        $pacienteToken->tokens()->delete();
        $token = $pacienteToken->createToken($paciente->pac_nome, ['id:' . $paciente->pac_codigo]);
        $nome = str_replace(' ', '-', strtolower($paciente->pac_nome));

        return response(['url_marcar_consulta' => 'api/consulta/'.$nome.'/'.$paciente->pac_codigo, 'token_acesso' => $token->plainTextToken], 201);
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

        $paciente = Paciente::find($id);

        if (!$paciente) {
            return response(['status' => 'Paciente não encontrado.'], 404);
        }

        $paciente->update([
            'pac_codigo' => $paciente->pac_codigo,
            'pac_nome' => $request->pac_nome ? $request->pac_nome : $paciente->pac_nome,
            'pac_telefone' => $request->pac_telefone ?  $request->pac_telefone :  $paciente->pac_telefone
        ]);

        return response($paciente, 200);
    }

    public function deletar($id)
    {
        $paciente =  Paciente::find($id);
        if (!$paciente) {
            return response(['status' => 'Paciente não encontrado nos registros.'], 404);
        }
        $paciente->delete();

        return response($paciente, 200);
    }
}
