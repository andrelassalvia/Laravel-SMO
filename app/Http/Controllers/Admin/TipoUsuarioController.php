<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TipoUsuarioFormRequest;

use App\Models\TipoUsuario;
use App\Models\Permissao;

use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\ChangeRegister;
use App\Classes\CheckDataBase;
use App\Classes\CheckToDelete;
use App\Classes\DeleteRegister;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

class TipoUsuarioController extends Controller
{
    use SuccessRedirectMessage, FailRedirectMessage;

    public function __construct (
        Permissao $permissao
    )
    {
        $this->permissao = $permissao;
    }
   
    public function index(TipoUsuario $tipoUsuario)
    {
        $this->authorize('view-any', $tipoUsuario);
        $table = $tipoUsuario->getTable();
        $data = new CollectData($tipoUsuario);
        $data = $data->collection('nome', 'ASC', false);
        return view ('admin.tipoUsuario.index', compact('table', 'data'));
    }

    public function create(TipoUsuario $tipoUsuario)
    {
        $this->authorize('create', $tipoUsuario);
        $table = $tipoUsuario;
        return view('admin.tipoUsuario.create', compact('table'));
    }

    public function store(TipoUsuarioFormRequest $request, TipoUsuario $tipoUsuario)
    {
        $this->authorize('create', $tipoUsuario);
        $dataForm = $request->validated();
        $data = new CheckDataBase($tipoUsuario);
        $data = $data->checkInDatabase(['nome'], [$dataForm['nome']]);
        if($data){
            $store = new SaveInDatabase($tipoUsuario);
            $store = $store->saveDatabase($data);
            return SuccessRedirectMessage::successRedirect(
                'tipousuario.index',
                ['success' => 'Tipo de usuario cadastrado com sucesso'],
                ''
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'tipousuario.create',
                ['errors' => 'Tipo de usuario já cadastrado'],
                ''
            );
        }
    }

    public function show(TipoUsuario $tipoUsuario, $id)
    {
        $this->authorize('view', $tipoUsuario);
        $data = TipoUsuario::find($id);
        return view('admin.tipoUsuario.show', compact('data'));
    }

    public function edit(TipoUsuario $tipoUsuario, $id)
    {
        $this->authorize('update', $tipoUsuario);
        $data = TipoUsuario::find($id);
        return view('admin.tipoUsuario.edit', compact('data'));
    }

    public function update(TipoUsuarioFormRequest $request, TipoUsuario $tipoUsuario, $id)
    {
        $this->authorize('update', $tipoUsuario);
        $dataForm = $request->validated();
        $alter = new CheckDataBase($tipoUsuario);
        $alter = $alter->checkInDatabase(
            ['nome'], 
            [$dataForm['nome']], 
        );

        if($alter){
            $newRegister = new ChangeRegister($tipoUsuario);
            $newRegister = $newRegister->changeRegisterInDatabase(
                $id,
                $alter
            );
            return SuccessRedirectMessage::successRedirect(
                'tipousuario.index',
                ['success' => 'Tipo de usuário alterado com sucesso'],
                $id
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'tipousuario.edit',
                ['errors' => 'Tipo de usuário já cadastrado'],
                $id
            );
        }
    }

    public function destroy(TipoUsuario $tipoUsuario, $id)
    {
        $this->authorize('delete', $tipoUsuario);
        $check = new CheckToDelete($tipoUsuario);
        $check = $check->checkDb(
            $id,
            [$this->permissao],
            ['tipousuario_id']
        );

        if($check){
            return FailRedirectMessage::failRedirect(
                'tipousuario.show',
                ['errors' => "Existe um registro vinculado a ". $check['table']],
                $id
            );
        } else {
            $delete = new DeleteRegister($tipoUsuario);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'tipousuario.index',
                ['success' => 'Tipo de usuário apagado com sucesso'],
                ''
            );
        }
    }
}
