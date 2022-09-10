<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultaMarcarValidation;
use App\Http\Requests\ConsultaValidation;
use App\Http\Requests\PacientePaginacaoValidation;
use App\Models\Consulta;
use App\Models\ConsultaMarcadas;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Procedimento;
use App\Models\Vinculo;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{

    public function listar(PacientePaginacaoValidation $request)
    {
        $registrosPorPagina = $request->registro_por_pagina;
        $consultas = Consulta::with('medico', 'procedimento')->paginate($registrosPorPagina);

        return response($consultas, 200);
    }

    public function cadastrarConsulta(ConsultaValidation $request)
    {


        $medico = Medico::with('especialidade')->where('med_codigo', $request->med_codigo)->get();
        if (!isset($medico[0])) {
            $medicoAll = Medico::with('especialidade')->get();
            return response(['medicos_disponiveis' => $medicoAll], 400);
        }

        $procedimento = Procedimento::with('especialidade')->where('proc_codigo', $request->proc_codigo)->get();
        if (!isset($procedimento[0])) {
            $procedimentoAll = Procedimento::with('especialidade')->get();
            return response(['procedimentos_disponiveis' => $procedimentoAll], 400);
        }


        if ($procedimento[0]->especialidade->espec_nome != $medico[0]->especialidade->espec_nome) {

            return response(['status' => 'Esse médico não é especialista nesse procedimento.'], 400);
        }

        $consCodigo = md5(uniqid(rand(), true));
        $consulta = Consulta::create([
            'cons_codigo' => $consCodigo,
            'cons_data' => $request->cons_data,
            'cons_hora' => $request->cons_hora,
            'proc_id' => $procedimento[0]->id,
            'med_id' => $medico[0]->id
        ]);

        return response($consulta, 201);
    }



    public function MarcarConsulta(ConsultaMarcarValidation $request)
    {


        $pac_codigo = $request->segment(4);
        $paciente = Paciente::where('pac_codigo', $pac_codigo)->get();
        $consulta = Consulta::with('medico', 'procedimento')->where('cons_codigo', $request->cons_codigo)->where('marcada', 0)->get();
        if (!isset($consulta[0])) {
            $consultaAll = Consulta::with('medico', 'procedimento')->where('marcada', 0)->get();
            return response(['consultas_disponiveis' => $consultaAll], 400);
        }
        $consultas = ConsultaMarcadas::with('consulta', 'medico', 'procedimento')->where('pac_id', $paciente[0]->id)->get();
        foreach ($consultas as $cons) {
            if ($cons->id != $consulta[0]->id) {
                return response(['status' => 'Essa consulta já foi marcada!!'], 400);
            }
        }
        $vinculo = Vinculo::where('paciente_id', $paciente[0]->id)->get();

        $consultaMarcada = ConsultaMarcadas::create([
            'cons_id' => $consulta[0]->id,
            'pac_id' => $paciente[0]->id,
            'med_id' => $consulta[0]->medico->id,
            'proc_id' => $consulta[0]->procedimento->id,
            'particular' => isset($vinculo[0]) ? '0' : '1',
            'nr_contrato' => isset($vinculo[0]) ? $vinculo[0]->nr_contrato : ''
        ]);

        $consultaEdit = Consulta::find($consulta[0]->id);
        $consultaEdit->marcada = '1';
        $consultaEdit->save();
        return response(['status' => 'Consulta marcada com sucesso!!'], 200);
    }


    public function listarConsultasMarcadas(Request $request)
    {

        $pac_codigo = $request->segment(4);
        $paciente = Paciente::where('pac_codigo', $pac_codigo)->get();
        $consultas = ConsultaMarcadas::with('consulta', 'medico', 'procedimento')->where('pac_id', $paciente[0]->id)->get();
        return response((isset($consultas[0])) ? $consultas : ['status' => 'Nenhuma consulta marcada no momento.'], 200);
    }
}
