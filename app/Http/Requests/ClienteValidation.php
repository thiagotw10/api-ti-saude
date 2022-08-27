<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteValidation extends FormRequest
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
            'nome' => 'required',
            'email' => 'required|email|unique:clientes',
            'telefone' => 'required',
            'cpf' => 'required|unique:clientes',
            'endereco'  => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'numero_casa' => 'required',
            'senha' => 'required',
            'status' => 'required',
            'cep' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Esse email já existe.',
            'cpf.unique' => 'Esse cpf já existe.'
        ];
    }
}
