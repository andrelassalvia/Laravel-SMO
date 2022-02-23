<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PermissaoFormRequest;

use App\Models\Permissao;
use App\Models\TipoUsuario;
use App\Models\Formulario;

use App\Classes\CollectData;
use App\Classes\DeleteRegister;
use App\Classes\SaveInDatabase;

class PermissaoController extends Controller
{
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

    public function store(PermissaoFormRequest $request, $id)
    {
        $dataForm = $request->validated();
        $tipoUsuario = TipoUsuario::find($id);
       
        $permissoes =new SaveInDatabase($this->permissao);

        $permissoes = $permissoes->saveDatabase(
            ['tipousuario_id', 'formulario_id', 'inclui', 'altera', 'exclui'],
            [
                $tipoUsuario->id, 
                $dataForm['formulario_id'], 
                $dataForm['inclui'],
                $dataForm['altera'],
                $dataForm['exclui']
            ],
            'permissao.index',
            ['success' => 'Registro cadastrado com sucesso'],
            'permissao.index',
            ['errors' => 'Registro já cadastrado'],
            $id
        );

        return $permissoes;
    }

    public function destroy($id)
    {
        $register = $this->permissao->find($id);
        $mainId = $register['tipousuario_id'];


        $permissao = new DeleteRegister($this->permissao);
        $permissao = $permissao->erase(
            $id,
            [],
            [],
            'permissao.index',
            'permissao.index',
            ['success' => 'Registro deletado com sucesso'],
            $mainId
        );

        return $permissao;
    }
}
