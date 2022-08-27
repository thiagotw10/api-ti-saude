<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ClienteValidation;
use App\Http\Requests\ClienteLoginValidation;
use App\Models\ClienteCarrinho;
use App\Models\produtosPainel;

use function PHPUnit\Framework\returnSelf;
use Illuminate\Support\Facades\Http;

class ClientesController extends Controller
{
    public function criarCliente(ClienteValidation $request)
    {

        $cliente = Clientes::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'endereco'  => $request->endereco,
            'complemento' => $request->complemento ? $request->complemento : "",
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'numero_casa' =>  $request->numero_casa,
            'cep' =>  $request->cep,
            'senha' => bcrypt($request->senha),
            'status' => $request->status,
        ]);

        return response($cliente, 201);
    }

    public function login(ClienteLoginValidation $request)
    {

        $cliente = Clientes::where('email', $request->email)->first();

        if (!$cliente) {
            return response(['status' => 'email ou senha incorreta'], 401);
        }

        if (password_verify($request->senha, $cliente->senha)) {
            $cliente->tokens()->delete();
            $token = $cliente->createToken($request->email, ['id:' . $cliente->id]);
            return response([
                'status' => 'logado com sucesso', 'usuario' => $cliente,
                'token' => $token->plainTextToken,
                'url_cliente' => 'api/cliente/' . str_replace(" ", "-", $cliente->nome) . '/' . $cliente->id,
                'url_enviar_carrinho' => 'api/cliente/carrinho/' . str_replace(" ", "-", $cliente->nome) . '/' . $cliente->id
            ], 200);
        } else {
            return response(['status' => 'email ou senha incorreta'], 401);
        }
    }

    public function listarCliente($id)
    {

        return response(Clientes::find($id), 200);
    }

    public function carrinhoCliente(Request $request, $id)
    {
        $carrinho = $request->carrinho;
        $dadosClientePagamento = [];
        foreach ($carrinho as $itemsCarrinho) {
            $produto = produtosPainel::find($itemsCarrinho['produto_id']);
            $dadosClientePagamento[$itemsCarrinho['quantidade']] = $produto->preco_do_produto_com_desconto ? (int)$produto->preco_do_produto_com_desconto : (int)$produto->preco_do_produto;
        }

        $valorTotal = [];
        foreach($dadosClientePagamento as $quantidade=>$valor){
            $valorTotal[] = $quantidade*$valor;
        }


        $clientes = Clientes::find($id);

        $valorSoma = array_sum($valorTotal);
        $idCliente = $id;
        $endereco = $clientes->endereco;
        $bairro = $clientes->bairro;
        $cidade = $clientes->cidade;
        $estado = $clientes->estado;
        $email = $clientes->email;
        $nomeCliente = $clientes->nome;
        $numeroCasa = $clientes->numero_casa;
        $metedoPagamento = $request->metedo_pagamento;
        $cep = $clientes->cep;
        $this->pagamentoPagseguro($idCliente, $endereco, $bairro, $cidade, $estado, $valorSoma, $email, $nomeCliente, $numeroCasa, $metedoPagamento, $request, $cep);

    }


    public function pagamentoPagseguro($idCliente, $endereco, $bairro, $cidade, $estado, $valorTotal, $email, $nomeCliente, $numeroCasa, $metedoPagamento, $request, $cep)
    {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer 04641609DDE84E84BD280D098911AC33',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://sandbox.api.pagseguro.com/charges',
            [
                'reference_id' =>   'id_cliente:'. $idCliente,
                'description' => 'Produtos tw10',
                'amount' =>
                [
                    'value' => $valorTotal*100,
                    'currency' => 'BRL',
                ],
                'payment_method' =>
                [
                    'type' => $metedoPagamento,
                    'boleto' =>
                    [
                        'due_date' => '2024-12-31',
                        'instruction_lines' =>
                        [
                            'line_1' => 'Pagamento processado para DESC Fatura',
                            'line_2' => 'Via PagSeguro',
                        ],
                        'holder' =>
                        [
                            'name' => $nomeCliente,
                            'tax_id' => '22222222222',
                            'email' => $email,
                            'address' =>
                            [
                                'street' => $endereco,
                                'number' => $numeroCasa,
                                'locality' => $bairro,
                                'city' => $cidade,
                                'region' => $estado,
                                'region_code' => 'SP',
                                'country' => 'Brasil',
                                'postal_code' => $cep,
                            ],
                        ],
                    ],
                ],
                'notification_urls' =>
                [
                    0 => 'https://yourserver.com/nas_ecommerce/277be731-3b7c-4dac-8c4e-4c3f4a1fdc46/',
                ],
            ]
        );


        if ($response->successful()) {

            $carrinho = $request->carrinho;
            foreach ($carrinho as $itemsCarrinho) {
                $produto = produtosPainel::find($itemsCarrinho['produto_id']);

                ClienteCarrinho::create([
                    "cliente_id" => $itemsCarrinho['cliente_id'],
                    "produto_id" => $itemsCarrinho['produto_id'],
                    "nome_produto" => $produto->nome_do_produto,
                    "valor" => $produto->preco_do_produto_com_desconto ? $produto->preco_do_produto_com_desconto : $produto->preco_do_produto,
                    "quantidade" => $itemsCarrinho['quantidade'],
                    "metedo_pagamento" => $request->metedo_pagamento
                ]);

                $produto->unidades_do_produto = $produto->unidades_do_produto - $itemsCarrinho['quantidade'];
                $produto->save();
            }

            return response($response, 200);
        }
    }
}
