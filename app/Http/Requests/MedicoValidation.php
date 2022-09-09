<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicoValidation extends FormRequest
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
         'medico' => 'required',
         'medico.med_nome' => 'required',
         'medico.med_CRM' => 'required|unique:medicos,med_CRM',
         'especialidade' => 'required',
         'especialidade.espec_nome' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'medico.required' => 'Objeto obrigátorio.',
            'medico.med_nome.required' => 'Campo obrigátorio.',
            'medico.med_CRM.required' => 'Campo obrigátorio.',
            'medico.med_CRM.unique' => 'Médico com esse CRM já existe.',
            'especialidade.required' => 'Objeto obrigátorio.',
            'especialidade.espec_nome.required' => 'Campo obrigátorio.',
        ];
    }
}
