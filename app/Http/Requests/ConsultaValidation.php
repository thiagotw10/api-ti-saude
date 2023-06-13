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
         'data' => 'required|date_format:d/m/Y',
         'hora' => 'required|date_format:H:i:s',
         'cons_med' => 'required',
         'cons_pac' => 'required',
         'vinculo_id' => 'required',
         'particular' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'data.required' => 'Campo obrigátorio.',
            'hora.required' => 'Campo obrigátorio.',
            'cons_med.required' => 'Campo obrigátorio.',
            'cons_pac.required' => 'Campo obrigátorio.',
            'vinculo_id.required' => 'Campo obrigátorio.',
            'particular.required' => 'Campo obrigátorio.',
            'data.date_format' => 'Campo invalido! Formato de exemplo: 14/11/1994.',
            'hora.date_format' => 'Campo invalido! Formato de exemplo: 12:59:12.',
        ];
    }
}
