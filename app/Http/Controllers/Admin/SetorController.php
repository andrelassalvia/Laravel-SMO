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
        Setor $setor,
        Atendimento $atendimento,
        Empregado $empregado,
        GrupoFuncao $grupoFuncao
    ) {
        $this->setor = $setor;
        $this->atendimento = $atendimento;
        $this->empregado = $empregado;
        $this->grupoFuncao = $grupoFuncao;
    }

    public function index()
    {
        $setores = new CollectData($this->setor);
        $data = $setores->collection('nome', 'ASC', false);
        
        return view ('admin.setor.index', compact('data'));
    }
    
    public function create()
    {
        $data = $this->setor;
        return view ('admin.setor.create', compact('data'));
    }

    public function store(SetorFormRequest $request)
    {
        $dataForm = $request->validated();
        $data = new CheckDataBase($this->setor);
        $data = $data->checkInDatabase(['nome'], [$dataForm['nome']]);
        if($data){
            $store = new SaveInDatabase($this->setor);
            $store = $store->saveDatabase($data);
            return SuccessRedirectMessage::successRedirect(
                'setor.index',
                ['success' => 'Setor cadastrado com sucesso'],
                ''
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'setor.create',
                ['errors' => 'Setor já cadastrado'],
                ''
            );
        }
    }

    public function show($id)
    {
        $data = Setor::find($id);
        return view ('admin.setor.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Setor::find($id);
        return view ('admin.setor.edit', compact('data'));
    }

    public function update(SetorFormRequest $request, $id)
    {
        $dataForm = $request->validated();
        $alter = new CheckDataBase($this->setor);
        $alter = $alter->checkInDatabase(
            ['nome'], 
            [$dataForm['nome']], 
        );

        if($alter){
            $newRegister = new ChangeRegister($this->setor);
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
                ['errors' => 'Setor já cadastrado'],
                $id
            );
        }
    }

    public function destroy($id)
    {
        $check = new CheckToDelete($this->setor);
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
            $delete = new DeleteRegister($this->setor);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'setor.index',
                ['success' => 'Setor apagado com sucesso'],
                ''
            );
        }
    }

    public function search(Request $request)
    {
        $dataForm = $request->validate([
            'nome' => 'required'
        ]);
        $nome = '%'.$dataForm['nome'].'%';
        $setores = new SearchRequest($this->setor);
        $data = $setores->searchIt('nome', ['nome' => $nome]);
        return view('admin.setor.index', compact('nome', 'data', 'dataForm'));
    }
}
