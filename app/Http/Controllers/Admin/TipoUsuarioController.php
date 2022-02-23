<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TipoUsuarioFormRequest;

use App\Models\TipoUsuario;
use App\Models\Permissao;

use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\ChangeRegister;
use App\Classes\DeleteRegister;

class TipoUsuarioController extends Controller
{
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
        $data = new ChangeRegister($this->tipoUsuario);
        $data = $data->changeRegisterInDatabase(
            $id,
            ['nome'],
            [$dataForm['nome']],
            'tipousuario.index',
            ['success' => 'Tipo de usuário alterado com sucesso'],
            'tipousuario.edit',
            ['errors' => 'Erro na alteração do registro']
        );

        return $data;
    }

    public function destroy($id)
    {
        $data = new DeleteRegister($this->tipoUsuario);
        $data = $data->erase(
            $id,
            [$this->permissao],
            ['tipousuario_id'],
            'tipousuario.show',
            'tipousuario.index',
            ['success' => 'Tipo de usuário deletado com sucesso'],
            ''
        );

        return $data;
    }
}
