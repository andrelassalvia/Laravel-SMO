<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GrupoFuncaoFormRequest;
use App\Models\GrupoFuncao;
use App\Models\Grupo;
use App\Models\Funcao;
use App\Models\Setor;
use App\Classes\GrupoFuncao\CollectData;
use App\Classes\GrupoFuncao\SaveInDatabase;
use App\Classes\GrupoFuncao\DeleteRegister;


class GrupoFuncaoController extends Controller
{
    public function __construct(GrupoFuncao $grupoFuncao, Grupo $grupo, Funcao $funcao, Setor $setor)
        {
            $this->grupoFuncao = $grupoFuncao;
            $this->grupo = $grupo;
            $this->funcao = $funcao;
            $this->setor = $setor;
        }

    public function index($id)
    {
        $grupo = $this->grupo->find($id);

        $funcoes = new CollectData($this->funcao);
        $funcoes = $funcoes->collection('nome', 'ASC');

        $setores = new CollectData($this->setor);
        $setores = $setores->collection('nome', 'ASC');

        $grupoFuncoes = $this->grupoFuncao->where('grupo_id', $id)->get();
        // dd($grupoFuncoes);
        

        return view ('admin.grupoFuncao.index', 
        [
            'grupo' => $grupo,
            'funcoes' => $funcoes,
            'setores' => $setores,
            'grupoFuncoes' => $grupoFuncoes
        ]);
       
    }

    public function store(GrupoFuncaoFormRequest $request, $id)
    {
        $dataForm = $request->all();
        
        $funcao_id = $dataForm['funcao_id'];
        $setor_id = $dataForm['setor_id'];

        $grupoFuncoes = new SaveInDatabase($this->grupoFuncao);
        $grupoFuncoes = $grupoFuncoes->saveDatabase
        (
            ['grupo_id', 'funcao_id', 'setor_id'],
            [$id, $funcao_id, $setor_id],
            'grupofuncao.index',
            ['success' => 'Registro cadastrado com sucesso'],
            'grupofuncao.index',
            ['errors' => 'Registro já cadastrado no banco de dados'],
            $id

        );

        return $grupoFuncoes;

    }

    public function destroy($id)
    {
        $register = $this->grupoFuncao->find($id);
        $grupo_id = $register['grupo_id'];
        
        $deleted = new DeleteRegister($this->grupoFuncao);
        $deleted = $deleted->erase
        (
            $id,
            [],
            [],
            'grupofuncao.index',
            'grupofuncao.index',
            ['success' => 'Registro deletado'],
            $grupo_id

        );

        return $deleted;

    }
}
