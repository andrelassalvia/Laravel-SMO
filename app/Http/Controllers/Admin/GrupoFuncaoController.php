<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\GrupoFuncao;
use App\Models\Grupo;
use App\Models\Funcao;
use App\Models\Setor;

use App\Http\Requests\Admin\GrupoFuncaoFormRequest;
use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\DeleteRegister;
use App\Classes\CheckToDelete;
use App\Classes\CheckDataBase;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

class GrupoFuncaoController extends Controller
{
    use SuccessRedirectMessage, FailRedirectMessage;

    public function __construct(
        GrupoFuncao $grupoFuncao, 
        Grupo $grupo, 
        Funcao $funcao, 
        Setor $setor
    ) 
    {
        $this->grupoFuncao = $grupoFuncao;
        $this->grupo = $grupo;
        $this->funcao = $funcao;
        $this->setor = $setor;
    }

    public function index($id)
    {
        $data = $this->grupo->find($id);
        $funcoes = new CollectData($this->funcao);
        $funcoes = $funcoes->collection('nome', 'ASC', true);
        $setores = new CollectData($this->setor);
        $setores = $setores->collection('nome', 'ASC', true);
        $grupoFuncoes = $this->grupoFuncao->where('grupo_id', $id)->get();
        return view (
            'admin.grupoFuncao.index', 
            compact('data', 'funcoes', 'setores', 'grupoFuncoes')
        );
    }

    public function store(GrupoFuncaoFormRequest $request, $id)
    {
        $dataForm = $request->validated();
        $data = new CheckDataBase($this->grupoFuncao);
        $data = $data->checkInDatabase(
            ['grupo_id', 'funcao_id', 'setor_id'], 
            [$id, $dataForm['funcao_id'], $dataForm['setor_id']]);
        if($data){
            $store = new SaveInDatabase($this->grupoFuncao);
            $store = $store->saveDatabase($data);
            return SuccessRedirectMessage::successRedirect(
                'grupofuncao.index',
                ['success' => 'Registro cadastrado com sucesso'],
                $id
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'grupofuncao.index',
                ['errors' => 'Registro j?? cadastrado'],
                $id
            );
        }
    }

    public function destroy($id)
    {
        $register = $this->grupoFuncao->find($id);
        $mainId = $register['grupo_id'];
        $check = new CheckToDelete($this->grupoFuncao);
        $check = $check->checkDb(
            $id,
            [],
            []
        );
        if($check){
            return FailRedirectMessage::failRedirect(
                'grupofuncao.index',
                ['errors' => "Existe um registro vinculado a ". $check['table']],
                $id
            );
        } else {
            $delete = new DeleteRegister($this->grupoFuncao);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'grupofuncao.index',
                ['success' => 'Registro apagado com sucesso'],
                $mainId
            );
        }
    }
}
