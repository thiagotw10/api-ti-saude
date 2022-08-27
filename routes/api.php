<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProdutosPainelController;
use App\Http\Controllers\SeguimentoProdutosPainelController;
use App\Http\Controllers\UsuarioAdministradorController;
use App\Models\Clientes;
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
Route::post('register', [UsuarioAdministradorController::class, 'register']);
// fim do usuario admin


// cliente
Route::post('cliente/login', [ClientesController::class, 'login']);
Route::post('cliente/register', [ClientesController::class, 'criarCliente']);
// fim de cliente

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


// cliente protegido pelo seu token
$clientes = Clientes::all();

foreach ($clientes as $cliente) {

    Route::middleware(['auth:sanctum', 'abilities:id:' . $cliente->id])->group(function () use ($cliente) {
        $nome = str_replace(' ', '-', strtolower($cliente->nome));
        Route::get('cliente/' .$nome.'/{id}', [ClientesController::class, 'listarCliente']);
        Route::post('cliente/carrinho/' .$nome.'/{id}', [ClientesController::class, 'carrinhoCliente']);
    });
}
// fim do cliente protegido
