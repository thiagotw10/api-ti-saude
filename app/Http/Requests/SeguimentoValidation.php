<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeguimentoValidation extends FormRequest
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
            'nome_seguimento' => 'required|string|unique:seguimento_produtos_painels',
            'nome_imagem' => 'required|string',
            'url_imagem' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'nome_seguimento.required' => 'Campo obrigátorio.',
            'nome_seguimento.unique' => 'Esse seguimento já existe.',
            'nome_imagem.required' => 'Campo obrigátorio.',
            'url_imagem.required' => 'Campo obrigátorio.',
        ];
    }
}
