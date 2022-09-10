<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultaValidation extends FormRequest
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

    /** 'cons_codigo','med_id','cons_data','cons_hora'
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
         'cons_data' => 'required|date_format:d/m/Y',
         'cons_hora' => 'required|date_format:H:i:s',
         'proc_codigo' => 'required',
         'med_codigo' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'proc_codigo.required' => 'Campo obrigátorio.',
            'med_codigo.required' => 'Campo obrigátorio.',
            'cons_data.required' => 'Campo obrigátorio.',
            'cons_hora.required' => 'Campo obrigátorio.',
            'cons_data.date_format' => 'Campo invalido! Formato de exemplo: 14/11/1994.',
            'cons_hora.date_format' => 'Campo invalido! Formato de exemplo: 12:59:12.',
        ];
    }
}
