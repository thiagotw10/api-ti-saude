<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PacienteValidation extends FormRequest
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
         'pac_nome' => 'required',
         'pac_telefone' => 'required|unique:pacientes,pac_telefone|telefone_com_ddd',
         'pac_dataNascimento' => 'required|date_format:d/m/Y',
        ];
    }

    public function messages()
    {
        return [
            'pac_nome.required' => 'Campo obrigátorio.',
            'pac_telefone.telefone_com_ddd' => 'Campo invalido! formato de exemplo: (99)9899-9548.',
            'pac_dataNascimento.required' => 'Campo obrigátorio.',
            'pac_dataNascimento.date_format' => 'Campo invalido! formato de exemplo: 01/12/1998.',

        ];
    }
}
