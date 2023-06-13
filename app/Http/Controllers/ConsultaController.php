<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultaMarcarValidation;
use App\Http\Requests\ConsultaValidation;
use App\Http\Requests\PacientePaginacaoValidation;
use App\Models\Cons_proc;
use App\Models\Consulta;
use App\Models\ConsultaMarcadas;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Procedimento;
use App\Models\Vinculo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{

    public function listar(PacientePaginacaoValidation $request)
    {
        $registrosPorPagina = $request->registro_por_pagina;
        $consultas = Consulta::with('medico', 'vinculo')->paginate($registrosPorPagina);

        return response($consultas, 200);
    }

    public function cadastrarConsulta(ConsultaValidation $request)
    {

        try {
            $consulta = Consulta::create([
                'data' => $request->data,
                'hora' => $request->hora,
                'cons_med' => $request->cons_med,
                'cons_pac' => $request->cons_pac,
                'vinculo_id' => $request->vinculo_id,
                'particular' => $request->particular,
            ]);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode === 1452) {
                // Lidar com a violação de chave estrangeira
                return response(['status' => 'Não foi possível adicionar o vínculo devido a uma violação de chave estrangeira.'], 422);
            }

            // Lidar com outros erros ou retornar uma resposta genérica
            return response(['status' => 'Ocorreu um erro durante a criação do vínculo.'], 500);
        }

        return response($consulta, 201);
    }
}
