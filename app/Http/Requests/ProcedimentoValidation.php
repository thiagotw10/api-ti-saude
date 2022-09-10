<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcedimentoValidation extends FormRequest
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
            'proc_nome' => 'required|string|unique:procedimentos',
            'proc_valor' => 'required|integer',
            'espec_codigo' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'proc_nome.required' => 'Campo obrigátorio.',
            'espec_id.required' => 'Campo obrigátorio.',
            'proc_nome.unique' => 'Esse nome de procedimento já existe.',
            'proc_valor.required' => 'Campo obrigátorio.',
            'proc_valor.integer' => 'Campo invalido! Exemplo: 200.',
        ];
    }
}
