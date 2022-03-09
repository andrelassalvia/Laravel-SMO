<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TipoAtendimento;
use App\Models\Atendimento;
use App\Models\GrupoExame;

use App\Http\Requests\Admin\TipoAtendimentoFormRequest;
use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\DeleteRegister;
use App\Classes\ChangeRegister;
use App\Classes\CheckDatabase;
use App\Classes\CheckToDelete;
use App\Classes\SearchRequest;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

class TipoAtendimentoController extends Controller
{
    use SuccessRedirectMessage, FailRedirectMessage;

    public function __construct(Atendimento $atendimento, GrupoExame $grupoExame)
    {
        $this->atendimento = $atendimento;
        $this->grupoExame = $grupoExame;
    }

    public function index(TipoAtendimento $tipoAtendimento)
    {
        $this->authorize('view-any', $tipoAtendimento);
        $tipoAtendimentos = new CollectData($tipoAtendimento);
        $data = $tipoAtendimentos->collection(
            'nome', 
            'ASC',
            false
        );
        return view(
            'admin.tipoAtendimento.index', 
            compact('data')
        );
    }

    public function create(TipoAtendimento $tipoAtendimento)
    {
        $this->authorize('create', $tipoAtendimento);
        $data = $tipoAtendimento;
        return view('admin.tipoAtendimento.create', compact('data'));
    }

    public function store(TipoAtendimentoFormRequest $request, TipoAtendimento $tipoAtendimento)
    {
        $this->authorize('create', $tipoAtendimento);

        $dataForm = $request->validated();
        $data = new CheckDataBase($tipoAtendimento);
        $data = $data->checkInDatabase(['nome'], [$dataForm['nome']]);
        if($data){
            $store = new SaveInDatabase($tipoAtendimento);
            $store = $store->saveDatabase($data);
            return SuccessRedirectMessage::successRedirect(
                'tipoatendimento.index',
                ['success' => 'Tipo de atendimento cadastrado com sucesso'],
                ''
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'tipoatendimento.create',
                ['errors' => 'Tipo de atendimento já cadastrado'],
                ''
            );
        }
    }

    public function show(TipoAtendimento $tipoAtendimento, $id)
    {
        $this->authorize('view', $tipoAtendimento);
        $data = TipoAtendimento::find($id);
        return view(
            'admin.tipoAtendimento.show', 
            compact('data'));
    }

    public function edit(TipoAtendimento $tipoAtendimento, $id)
    {
        $this->authorize('update', $tipoAtendimento);
        $data = TipoAtendimento::find($id);
        return view(
            'admin.tipoAtendimento.edit',
            compact('data')
        );
    }

    public function update(
        TipoAtendimentoFormRequest $request, 
        TipoAtendimento $tipoAtendimento, 
        $id
    )
    {
        $this->authorize('update', $tipoAtendimento);
        $dataForm = $request->validated();
        $alter = new CheckDataBase($tipoAtendimento);
        $alter = $alter->checkInDatabase(
            ['nome'], 
            [$dataForm['nome']], 
        );

        if($alter){
            $newRegister = new ChangeRegister($tipoAtendimento);
            $newRegister = $newRegister->changeRegisterInDatabase(
                $id,
                $alter
            );
            return SuccessRedirectMessage::successRedirect(
                'tipoatendimento.index',
                ['success' => 'Tipo de atendimento alterado com sucesso'],
                $id
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'tipoatendimento.edit',
                ['errors' => 'Tipo de atendimento já cadastrado'],
                $id
            );
        }
    }

    public function destroy($id, TipoAtendimento $tipoAtendimento)
    {
        $this->authorize('delete', $tipoAtendimento);
        $check = new CheckToDelete($tipoAtendimento);
        $check = $check->checkDb(
            $id,
            [$this->atendimento, $this->grupoExame],
            ['tipoatendimento_id']
        );

        if($check){
            return FailRedirectMessage::failRedirect(
                'tipoatendimento.show',
                ['errors' => "Existe um registro vinculado a ". $check['table']],
                $id
            );
        } else {
            $delete = new DeleteRegister($tipoAtendimento);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'tipoatendimento.index',
                ['success' => 'Tipo de atendimento apagado com sucesso'],
                ''
            );
        }
    }

    public function search(Request $request, TipoAtendimento $tipoAtendimento)
    {
        $dataForm = $request->validate([
            'nome' => 'required'
        ]);
        $data = '%'.$dataForm['nome'].'%';
        $tipoAtendimentos = new SearchRequest($tipoAtendimento);
        $tipoAtendimentos = $tipoAtendimentos->searchIt(
            'nome',
           ['data' => $data]
        );

        return view(
            'admin.tipoAtendimento.index',
            compact('tipoAtendimentos', 'data', 'dataForm')
        );
    }
}
