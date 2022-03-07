<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissaoFormRequest;

use App\Models\Permissao;
use App\Models\TipoUsuario;
use App\Models\Formulario;

use App\Classes\CollectData;
use App\Classes\DeleteRegister;
use App\Classes\SaveInDatabase;
use App\Classes\CheckDataBase;
use App\Classes\CheckToDelete;
use App\Classes\ChangeRegister;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

class PermissaoController extends Controller
{
    use FailRedirectMessage, SuccessRedirectMessage;

    public function __construct(
        Permissao $permissao,
        TipoUsuario $tipoUsuario,
        Formulario $formulario
    )
    {
        $this->permissao = $permissao;
        $this->tipoUsuario = $tipoUsuario;
        $this->formulario = $formulario;
    }

    public function index($id)
    {
        $data = TipoUsuario::find($id);
        $formularios = new CollectData($this->formulario);
        $formularios = $formularios->collection('nome', 'ASC',true);
        $permissoes = $this->permissao->where('tipousuario_id', $data->id)->get();
        return view('admin.permissao.index', compact('data', 'formularios', 'permissoes'));
    }

    public function edit($id)
    {
        $permissao = $this->permissao->find($id);
        $data = $this->tipoUsuario->where('id', $permissao['tipousuario_id'])->get()->first();
        $formularios = $this->formulario->where('id', $permissao['formulario_id'])->get()->first();
        return view ('admin.permissao.edit', compact('data', 'formularios', 'permissao'));
    }

    public function store(PermissaoFormRequest $request, $id)
    {
        $dataForm = $request->validated();
        $data = new CheckDataBase($this->permissao);
        $data = $data->checkInDatabase(
            ['tipousuario_id', 'formulario_id'], 
            [
                $id,
                $dataForm['formulario_id']
         ]);
        if($data){
            $store = new SaveInDatabase($this->permissao);
            $newData = array_combine(
                ['tipousuario_id', 'formulario_id', 'inclui', 'altera', 'exclui'],
                [
                    $id, 
                    $dataForm['formulario_id'],
                    $dataForm['inclui'],
                    $dataForm['altera'],
                    $dataForm['exclui']
                ]
            );
            $store = $store->saveDatabase($newData);
            return SuccessRedirectMessage::successRedirect(
                'permissao.index',
                ['success' => 'Registro cadastrado com sucesso'],
                $id
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'permissao.index',
                ['errors' => 'Registro já cadastrado'],
                $id
            );
        }
    }

    public function update(PermissaoFormRequest $request, $id)
    {
        $register = $this->permissao->find($id);
        $usuarioId = $register['tipousuario_id'];
        $formularioId = $register['formulario_id'];
        $dataForm = $request->validated();
        $alter = new CheckDataBase($this->permissao);
        $alter = $alter->checkInDatabase(
            ['tipousuario_id','formulario_id','inclui', 'altera', 'exclui'],
            [
                        $usuarioId, 
                        $formularioId, 
                        $dataForm['inclui'], 
                        $dataForm['altera'], 
                        $dataForm['exclui']
            ]
        );
        if($alter){
            $newValue = new ChangeRegister($this->permissao);
            $newValue = $newValue->changeRegisterInDatabase(
                $id,
                $alter
            );
            return SuccessRedirectMessage::successRedirect(
                'permissao.index',
                ['success' => 'Permissões alteradas com sucesso'],
                $usuarioId
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'permissao.edit', 
                ['errors' => 'Permissões selecionadas são iguais às anteriores'],
                $id
            );
        }
        return $alter;
    }

    public function destroy($id)
    {
        $register = $this->permissao->find($id);
        $mainId = $register['tipousuario_id'];
        $check = new CheckToDelete($this->permissao);
        $check = $check->checkDb(
            $id,
            [],
            []
        );
        if($check){
            return FailRedirectMessage::failRedirect(
                'permissao.index',
                ['errors' => "Existe um registro vinculado a ". $check['table']],
                $id
            );
        } else {
            $delete = new DeleteRegister($this->permissao);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'permissao.index',
                ['success' => 'Permissão apagada com sucesso'],
                $mainId
            );
        }
    }
}
