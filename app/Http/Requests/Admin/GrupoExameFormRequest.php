<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GrupoExameFormRequest extends FormRequest
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
            'exame_id'=>'required|exists:exame,id|digits_between:1,30',
            'tipoatendimento_id' => 'required|exists:tipoatendimento,id|digits_between:1,30'
        ];
    }

    public function messages()
    {
        return [
            'exame_id.required' => 'O campo exame é obrigatório',
            'tipoatendimento_id.required' => 'O campo atendimento é obrigatório'
        ];
    }
}
