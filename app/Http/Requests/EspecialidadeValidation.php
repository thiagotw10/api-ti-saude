<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EspecialidadeValidation extends FormRequest
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
            'espec_nome' => 'required|string|unique:especialidades',
        ];
    }

    public function messages()
    {
        return [
            'espec_nome.required' => 'Campo obrigátorio.',
            'espec_nome.unique' => 'Esse nome de especialidade já existe.',
        ];
    }
}
