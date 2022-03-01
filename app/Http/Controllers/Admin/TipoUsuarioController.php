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
        TipoUsuario $tipoUsuario,
        Permissao $permissao
    )
    {
        $this->tipoUsuario = $tipoUsuario;
        $this->permissao = $permissao;
    }
   
    public function index()
    {
        $table = $this->tipoUsuario->getTable();
        $data = new CollectData($this->tipoUsuario);
        $data = $data->collection('nome', 'ASC', false);

        return view ('admin.tipoUsuario.index', compact('table', 'data'));
    }

    public function create()
    {
        
        $table = $this->tipoUsuario;
        return view('admin.tipoUsuario.create', compact('table'));
    }

    public function store(TipoUsuarioFormRequest $request)
    {
        $dataForm = $request->validated();
        $data = new SaveInDatabase($this->tipoUsuario);
        $data = $data->saveDatabase(
            ['nome'],
            [$dataForm['nome']],
            'tipousuario.index',
            ['success' => 'Tipo de usuário cadastrado com sucesso'],
            'tipousuario.create',
            ['errors' => 'Erro no cadastramento'],
            ''
        );

        return $data;
    }

    public function show($id)
    {
        $data = TipoUsuario::find($id);
        return view('admin.tipoUsuario.show', compact('data'));
    }

    public function edit($id)
    {
        $data = TipoUsuario::find($id);
        return view('admin.tipoUsuario.edit', compact('data'));
    }

    public function update(TipoUsuarioFormRequest $request, $id)
    {
        $dataForm = $request->validated();

        $alter = new CheckDataBase($this->tipoUsuario);
        $alter = $alter->checkInDatabase(
            ['nome'], 
            [$dataForm['nome']], 
        );

        if($alter){
            $newRegister = new ChangeRegister($this->tipoUsuario);
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

    public function destroy($id)
    {
        $check = new CheckToDelete($this->tipoUsuario);
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
            $delete = new DeleteRegister($this->tipoUsuario);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'tipousuario.index',
                ['success' => 'Tipo de usuário apagado com sucesso'],
                ''
            );
        }
    }
}
