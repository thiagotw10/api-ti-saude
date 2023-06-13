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
         'med_nome' => 'required',
         'med_CRM' => 'required|unique:medicos,med_CRM',
         'med_espec' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'med_nome.required' => 'Campo obrigátorio.',
            'med_CRM.required' => 'Campo obrigátorio.',
            'med_CRM.unique' => 'Médico com esse CRM já existe.',
            'med_espec.required' => 'Campo obrigátorio.',
        ];
    }
}
