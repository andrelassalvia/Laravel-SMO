<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GrupoFuncaoFormRequest extends FormRequest
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
        return 
            [
                'funcao_id' => 'required',
                'setor_id' => 'required'
            ];
            
    }

    public function messages()
    {
        return 
        [
                'funcao_id.required' => 'O campo função é obrigatório',
                'setor_id.required' => 'O campo setor é obrigatório'
        ];
    }
}
