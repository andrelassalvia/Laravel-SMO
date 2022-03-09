<?php

namespace App\Http\Controllers\Admin;

use App\AbstractClasses\CheckDataBase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Grupo;
use App\Models\Atendimento;
use App\Models\Empregado;
use App\Models\GrupoExame;
use App\Models\GrupoRisco;
use App\Models\GrupoFuncao;

use App\Http\Requests\Admin\GrupoFormRequest; 
use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\ChangeRegister;
use App\Classes\CheckToDelete;
use App\Classes\DeleteRegister;
use App\Classes\SearchRequest;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

class GrupoController extends Controller
{
    use SuccessRedirectMessage, FailRedirectMessage;

    public function __construct(
        Atendimento $atendimento,
        Empregado $empregado,
        GrupoExame $grupoExame,
        GrupoRisco $grupoRisco,
        GrupoFuncao $grupoFuncao
    ) 
    {
        $this->atendimento = $atendimento;
        $this->empregado = $empregado;
        $this->grupoExame = $grupoExame;
        $this->grupoRisco = $grupoRisco;
        $this->grupoFuncao = $grupoFuncao;
    }
    
    public function index(Grupo $grupo)
    {
        $this->authorize('view-any', $grupo);
        $grupos = new CollectData($grupo);
        $data = $grupos->collection('nome', 'ASC', false);
        return view ('admin.grupo.index', compact('data'));
    }
  
    public function create(Grupo $grupo)
    {
        $this->authorize('create', $grupo);
        $data = $grupo;
        return view ('admin.grupo.create', compact('data'));
    }

    public function store(GrupoFormRequest $request, Grupo $grupo)
    {
        $this->authorize('create', $grupo);
        $dataForm = $request->validated();
        $data = new CheckDataBase($grupo);
        $data = $data->checkInDatabase(['nome'], [$dataForm['nome']]);
        if($data){
            $store = new SaveInDatabase($grupo);
            $store = $store->saveDatabase($data);
            return SuccessRedirectMessage::successRedirect(
                'grupo.index',
                ['success' => 'Grupo cadastrado com sucesso'],
                ''
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'grupo.create',
                ['errors' => 'Grupo já cadastrado'],
                ''
            );
        }
    }
    
    public function show(Grupo $grupo, $id)
    {
        $this->authorize('view', $grupo);
        $data = Grupo::find($id);
        return view ('admin.grupo.show', compact('data'));
    }

    public function edit(Grupo $grupo, $id)
    {
        $this->authorize('update', $grupo);
        $data = Grupo::find($id);
        return view ('admin.grupo.edit', compact('data'));
    }

    public function update(GrupoFormRequest $request, Grupo $grupo, $id)
    {
        $this->authorize('update', $grupo);
        $dataForm = $request->validated();
        $alter = new CheckDataBase($grupo);
        $alter = $alter->checkInDatabase(
            ['nome'], 
            [$dataForm['nome']], 
        );

        if($alter){
            $newRegister = new ChangeRegister($grupo);
            $newRegister = $newRegister->changeRegisterInDatabase(
                $id,
                $alter
            );
            return SuccessRedirectMessage::successRedirect(
                'grupo.index',
                ['success' => 'Grupo alterado com sucesso'],
                $id
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'grupo.edit',
                ['errors' => 'Grupo já cadastrado'],
                $id
            );
        }
    }

    public function destroy(Grupo $grupo, $id)
    {
        $this->authorize('delete', $grupo);
        $check = new CheckToDelete($grupo);
        $check = $check->checkDb(
            $id,
            [
                $this->atendimento,
                $this->empregado, 
                $this->grupoExame,
                $this->grupoRisco,
                $this->grupoFuncao
            ],
            ['grupo_id']
        );
        if($check){
            return FailRedirectMessage::failRedirect(
                'grupo.show',
                ['errors' => "Existe um registro vinculado a ". $check['table']],
                $id
            );
        } else {
            $delete = new DeleteRegister($grupo);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'grupo.index',
                ['success' => 'Grupo apagado com sucesso'],
                ''
            );
        }
    }

    public function search(Request $request, Grupo $grupo)
    {
        $dataForm = $request->validate([
            'nome' => 'required'
        ]);
        $nome = '%'.$dataForm['nome'].'%';
        $grupos = new SearchRequest($grupo);
        $data = $grupos->searchIt('nome', ['nome' => $nome]);
        return view('admin.grupo.index', compact('nome', 'data', 'dataForm'));
    }
}
