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

    public function __construct(
        TipoAtendimento $tipoAtendimento,
        Atendimento $atendimento,
        GrupoExame $grupoExame
        )
    {
        $this->tipoAtendimento = $tipoAtendimento;
        $this->atendimento = $atendimento;
        $this->grupoExame = $grupoExame;
    }

    public function index()
    {
        $tipoAtendimentos = new CollectData($this->tipoAtendimento);
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

    public function create()
    {
        $data = $this->tipoAtendimento;
        return view('admin.tipoAtendimento.create', compact('data'));
    }

    public function store(TipoAtendimentoFormRequest $request)
    {
        $dataForm = $request->validated();
        $data = new CheckDataBase($this->tipoAtendimento);
        $data = $data->checkInDatabase(['nome'], [$dataForm['nome']]);
        if($data){
            $store = new SaveInDatabase($this->tipoAtendimento);
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

    public function show($id)
    {
        $data = $this->tipoAtendimento->find($id);

        return view(
            'admin.tipoAtendimento.show', 
            compact('data'));
    }

    public function edit($id)
    {
        $data = $this->tipoAtendimento->find($id);

        return view(
            'admin.tipoAtendimento.edit',
            compact('data')
        );
    }

    public function update(TipoAtendimentoFormRequest $request, $id)
    {
        $dataForm = $request->validated();

        $alter = new CheckDataBase($this->tipoAtendimento);
        $alter = $alter->checkInDatabase(
            ['nome'], 
            [$dataForm['nome']], 
        );

        if($alter){
            $newRegister = new ChangeRegister($this->tipoAtendimento);
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

    public function destroy($id)
    {
        $check = new CheckToDelete($this->tipoAtendimento);
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
            $delete = new DeleteRegister($this->tipoAtendimento);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'tipoatendimento.index',
                ['success' => 'Tipo de atendimento apagado com sucesso'],
                ''
            );
        }
    }

    public function search(Request $request)
    {
        $dataForm = $request->validate([
            'nome' => 'required'
        ]);
        $data = '%'.$dataForm['nome'].'%';
        $tipoAtendimentos = new SearchRequest($this->tipoAtendimento);
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
