<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutosValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'seguimento_id' => 'required|string',
            'nome_do_produto' => 'required|string|unique:produtos_painels',
            'descricao_do_produto' => 'required|string|min:6',
            'preco_do_produto' => 'required|string',
            'preco_do_produto_com_desconto' => 'required|string',
            'unidades_do_produto' => 'required|string',
            'posicao_do_produto' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'seguimento_id.required' => 'Campo obrigátorio.',
            'nome_do_produto.unique' => 'Esse produto já existe.',
            'descricao_do_produto.required' => 'Campo obrigátorio.',
            'preco_do_produto.required' => 'Campo obrigátorio.',
            'preco_do_produto_com_desconto.required' => 'Campo obrigátorio.',
            'unidades_do_produto.required' => 'Campo obrigátorio.',
            'posicao_do_produto.required' => 'Campo obrigátorio.',
        ];
    }
}
