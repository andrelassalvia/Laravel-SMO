<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermissaoFormRequest extends FormRequest
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
            'formulario_id' => 'required',
            'nome' => 'required|min:3|max:30',
            'tipousuario_id' => 'exists:tipousuario,id',
            'formulario_id' => 'exists:formulario,id',
            'inclui' => 'digits_between:0,1',
            'exclui' => 'digits_between:0,1',
            'altera' => 'digits_between:0,1'
        ];
    }
}
