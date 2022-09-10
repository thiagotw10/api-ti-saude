<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProcedimentoController;
use App\Http\Controllers\ProdutosPainelController;
use App\Http\Controllers\SeguimentoProdutosPainelController;
use App\Http\Controllers\UsuarioAdministradorController;
use App\Models\Clientes;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\SeguimentoProdutosPainel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// usuario admin
Route::post('login', [UsuarioAdministradorController::class, 'authenticate']);
Route::post('registrar', [UsuarioAdministradorController::class, 'register']);
// fim do usuario admin

// cadastrar paciente
Route::post('pacientes', [PacienteController::class, 'cadastrar']);
// fim paciente

Route::group(['middleware' => ['jwt.verify']], function () {


    Route::get('pacientes', [PacienteController::class, 'listar']);
    Route::get('pacientes/{nome}', [PacienteController::class, 'buscarPaciente']);
    Route::put('pacientes/{id}', [PacienteController::class, 'editar']);
    Route::delete('pacientes/{id}', [PacienteController::class, 'deletar']);

    Route::get('medicos', [MedicoController::class, 'listar']);
    Route::get('medicos/{nome}', [MedicoController::class, 'buscarMedico']);
    Route::post('medicos', [MedicoController::class, 'cadastrar']);
    Route::put('medicos/{id}', [MedicoController::class, 'editar']);
    Route::delete('medicos/{id}', [MedicoController::class, 'deletar']);

    Route::get('procedimentos', [ProcedimentoController::class, 'listar']);
    Route::get('procedimentos/{nome}', [ProcedimentoController::class, 'buscarProcedimento']);
    Route::post('procedimentos', [ProcedimentoController::class, 'cadastrar']);
    Route::put('procedimentos/{id}', [ProcedimentoController::class, 'editar']);
    Route::delete('procedimentos/{id}', [ProcedimentoController::class, 'deletar']);

    Route::get('consultas', [ConsultaController::class, 'listar']);
    Route::post('consultas', [ConsultaController::class, 'cadastrarConsulta']);
});


$pacientes = Paciente::all();
foreach ($pacientes as $paciente) {
    Route::middleware(['auth:sanctum', 'abilities:id:' . $paciente->pac_codigo])->group(function () use ($paciente) {
        $nome = str_replace(' ', '-', strtolower($paciente->pac_nome));
        Route::get('consultas/' . $nome . '/' . $paciente->pac_codigo, [ConsultaController::class, 'listarConsultasMarcadas']);
        Route::post('consultas/' . $nome . '/' . $paciente->pac_codigo, [ConsultaController::class, 'MarcarConsulta']);
    });
}
