<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setor;
use App\Models\Atendimento;
use App\Models\Empregado;
use App\Models\GrupoFuncao;

use App\Http\Requests\Admin\SetorFormRequest;
use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\ChangeRegister;
use App\Classes\CheckDatabase;
use App\Classes\CheckToDelete;
use App\Classes\DeleteRegister;
use App\Classes\SearchRequest;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

class SetorController extends Controller
{
    use SuccessRedirectMessage, FailRedirectMessage;

    public function __construct(
        Atendimento $atendimento,
        Empregado $empregado,
        GrupoFuncao $grupoFuncao
    ) {
        $this->atendimento = $atendimento;
        $this->empregado = $empregado;
        $this->grupoFuncao = $grupoFuncao;
    }

    public function index(Setor $setor)
    {
        $this->authorize('view-any', $setor);
        $setores = new CollectData($setor);
        $data = $setores->collection('nome', 'ASC', false);
        
        return view ('admin.setor.index', compact('data'));
    }
    
    public function create(Setor $setor)
    {
        $this->authorize('create', $setor);
        $data = $setor;
        return view ('admin.setor.create', compact('data'));
    }

    public function store(SetorFormRequest $request, Setor $setor)
    {
        $this->authorize('create', $setor);
        $dataForm = $request->validated();
        $data = new CheckDataBase($setor);
        $data = $data->checkInDatabase(['nome'], [$dataForm['nome']]);
        if($data){
            $store = new SaveInDatabase($setor);
            $store = $store->saveDatabase($data);
            return SuccessRedirectMessage::successRedirect(
                'setor.index',
                ['success' => 'Setor cadastrado com sucesso'],
                ''
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'setor.create',
                ['errors' => 'Setor j?? cadastrado'],
                ''
            );
        }
    }

    public function show(Setor $setor, $id)
    {
        $this->authorize('view', $setor);
        $data = Setor::find($id);
        return view ('admin.setor.show', compact('data'));
    }

    public function edit(Setor $setor, $id)
    {
        $this->authorize('update', $setor);
        $data = Setor::find($id);
        return view ('admin.setor.edit', compact('data'));
    }

    public function update(SetorFormRequest $request, Setor $setor, $id)
    {
        $this->authorize('update', $setor);
        $dataForm = $request->validated();
        $alter = new CheckDataBase($setor);
        $alter = $alter->checkInDatabase(
            ['nome'], 
            [$dataForm['nome']], 
        );

        if($alter){
            $newRegister = new ChangeRegister($setor);
            $newRegister = $newRegister->changeRegisterInDatabase(
                $id,
                $alter
            );
            return SuccessRedirectMessage::successRedirect(
                'setor.index',
                ['success' => 'Setor alterado com sucesso'],
                $id
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'setor.edit',
                ['errors' => 'Setor j?? cadastrado'],
                $id
            );
        }
    }

    public function destroy(Setor $setor, $id)
    {
        $this->authorize('delete', $setor);
        $check = new CheckToDelete($setor);
        $check = $check->checkDb(
            $id,
            [$this->empregado, $this->atendimento, $this->grupoFuncao],
            ['setor_id']
        );

        if($check){
            return FailRedirectMessage::failRedirect(
                'setor.show',
                ['errors' => "Existe um registro vinculado a ". $check['table']],
                $id
            );
        } else {
            $delete = new DeleteRegister($setor);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'setor.index',
                ['success' => 'Setor apagado com sucesso'],
                ''
            );
        }
    }

    public function search(Request $request, Setor $setor)
    {
        $dataForm = $request->validate([
            'nome' => 'required'
        ]);
        $nome = '%'.$dataForm['nome'].'%';
        $setores = new SearchRequest($setor);
        $data = $setores->searchIt('nome', ['nome' => $nome]);
        return view('admin.setor.index', compact('nome', 'data', 'dataForm'));
    }
}
