<?php

namespace App\Http\Controllers;

use App\Models\Cons_proc;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ConsProcController extends Controller
{
    public function marcarConsulta(Request $request)
    {

        try {
            $consulta = Cons_proc::create([
                'procedimento_id' => $request->data,
                'consulta_id' => $request->hora,
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
