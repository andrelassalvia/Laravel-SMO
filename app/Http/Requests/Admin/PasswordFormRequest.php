<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PasswordFormRequest extends FormRequest
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
            'last_password' => 'required',
            'password' => 'required|min:6|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'last_password.required' => 'O campo Senha Anterior é obrigatório',
            'password.required' => 'O campo Senha Nova é obrigatório',
            'password.confirmed' => 'A confirmação da senha não coincide'
        ];
    }
}
