<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class EmpregadoFormRequest extends FormRequest
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
            'nome' => 'required|string|min:3|max:30',
            'cpf' => 'required|max:11',
            'ctps' => 'required',
            'serie' => 'required',
            'data_nascimento' => 'required|date|before:'.Carbon::today()->toDateString(),
            'data_admissao' => 'required|date|before:'.Carbon::now()->toDateString().'|after:data_nascimento',
            'data_demissao' => 'nullable|date|before:'.Carbon::now()->toDateString().'|after:data_admissao',
            'setor_id' => 'required|exists:grupofuncao,setor_id|integer',
            'funcao_id' => 'required|exists:grupofuncao,funcao_id|integer',
            'grupo_id' => 'required|exists:grupofuncao,grupo_id|integer'
        ];
    }
}
