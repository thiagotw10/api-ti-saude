<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanosaudeValidation extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
         'plano_descricao' => 'required|unique:plano_saudes',
         'plano_telefone' => 'required|unique:plano_saudes,plano_telefone|telefone_com_ddd',
        ];
    }

    public function messages()
    {
        return [
            'plano_descricao.required' => 'Campo obrigátorio.',
            'plano_telefone.telefone_com_ddd' => 'Campo invalido! formato de exemplo: (99)9899-9548.',
            'plano_descricao.unique' => 'Já existe um plano_descricao com esse nome',
            'plano_telefone.unique' => 'Já existe um plano_telefone com esse telefone',
        ];
    }
}
