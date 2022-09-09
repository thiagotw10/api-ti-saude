<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PacientePaginacaoValidation extends FormRequest
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
         'registro_por_pagina' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'registro_por_pagina.required' => 'Campo obrigátorio.',
            'registro_por_pagina.integer' => 'Campo só pode ser numero.',
        ];
    }
}
