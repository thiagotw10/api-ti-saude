<?php

use App\Http\Controllers\ProdutosPainelController;
use App\Http\Controllers\SeguimentoProdutosPainelController;
use App\Http\Controllers\UsuarioAdministradorController;
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

Route::post('login', [UsuarioAdministradorController::class, 'authenticate']);
Route::post('register', [UsuarioAdministradorController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function () {
    // usuarios
    Route::get('usuarios', [UsuarioAdministradorController::class, 'listarUsuarios']);
    // fim de usuarios


    // produtosPainel
    Route::get('produtos', [ProdutosPainelController::class, 'listarProdutos']);
    Route::post('produtos', [ProdutosPainelController::class, 'criarProdutos']);
    // fim de produtos painel

    // produtosPainel
    Route::get('seguimentos', [SeguimentoProdutosPainelController::class, 'listarSeguimentos']);
    Route::post('seguimentos', [SeguimentoProdutosPainelController::class, 'criarSeguimentos']);
    // fim de produtos painel
});
