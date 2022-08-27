<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteLoginValidation extends FormRequest
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


    public function rules()
    {
        return [
            'email' => 'required|email',
            'senha' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Campo obrigátorio.',
            'senha.required' => 'Campo obrigátorio.',
        ];
    }
}
