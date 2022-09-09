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
         'paciente' => 'required',
         'paciente.pac_nome' => 'required',
         'paciente.pac_telefone' => 'required|unique:pacientes,pac_telefone|telefone_com_ddd',
         'paciente.pac_dataNascimento' => 'required|date_format:d/m/Y',
         'planos_de_saude.*.plano_telefone' => 'telefone_com_ddd',
        ];
    }

    public function messages()
    {
        return [
            'paciente.required' => 'Objeto obrigátorio.',
            'paciente.pac_nome.required' => 'Campo obrigátorio.',
            'paciente.pac_dataNascimento.required' => 'Campo obrigátorio.',
            'paciente.pac_dataNascimento.date_format' => 'Campo invalido! formato de exemplo: 01/12/1998.',
            'paciente.pac_telefone.unique' => 'Paciente com esse numero de telefone já existe.',
            'paciente.pac_telefone.telefone_com_ddd' => 'Campo invalido! Exemplo valido: (99)9999-9999.',
            'paciente.pac_telefone.required' => 'Campo obrigátorio.',
            'planos_de_saude.required' => 'Objeto obrigátorio.',
            'planos_de_saude.plano_descricao.required' => 'campo obrigátorio.',
            'planos_de_saude.plano_telefone.required' => 'campo obrigátorio.',
            'planos_de_saude.*.plano_telefone.telefone_com_ddd' => 'Campo invalido! Exemplo valido: (99)9999-9999.',

        ];
    }
}
