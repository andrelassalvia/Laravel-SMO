<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Risco;
use App\Models\TipoRisco;
use App\Models\AtendimentoRisco;
use App\Models\GrupoRisco;

use App\Http\Requests\Admin\RiscoFormRequest;
use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\DeleteRegister;
use App\Classes\CheckDatabase;
use App\Classes\CheckToDelete;
use App\Classes\ChangeRegister;
use App\Classes\SearchRequest;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

class RiscoController extends Controller
{
    use SuccessRedirectMessage, FailRedirectMessage;

    public function __construct(
        TipoRisco $tipoRisco,
        AtendimentoRisco $atendimentoRisco,
        GrupoRisco $grupoRisco
        
    )
    {
        $this->tipoRisco = $tipoRisco;
        $this->atendimentoRisco = $atendimentoRisco;
        $this->grupoRisco = $grupoRisco;
    }

    public function index(Risco $risco)
    {
        $this->authorize('view-any', $risco);
        $riscos = new CollectData($risco);
        $data = $riscos->collection('nome', 'ASC', false);
        return view ('admin.risco.index', compact('data'));
    }
   
    public function create(Risco $risco)
    {
        $this->authorize('create', $risco);
        $data = $risco;
        $tipoRiscos = new CollectData($this->tipoRisco);
        $tipoRiscos = $tipoRiscos->collection('nome', 'ASC', true);
        return view ('admin.risco.create', compact('tipoRiscos', 'data'));
    }
     
    public function store(RiscoFormRequest $request, Risco $risco)
    {
        $this->authorize('create', $risco);

        $dataForm = $request->validated();
        $data = new CheckDataBase($risco);
        $data = $data->checkInDatabase(
            ['nome'], 
            [$dataForm['nome']]);
        if($data){
            $store = new SaveInDatabase($risco);
            $store = $store->saveDatabase($data);
            return SuccessRedirectMessage::successRedirect(
                'risco.index',
                ['success' => 'Risco cadastrado com sucesso'],
                ''
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'risco.create',
                ['errors' => 'Risco já cadastrado'],
                ''
            );
        }
    }

    public function show(Risco $risco, $id)
    {
        $this->authorize('view', $risco);
        $data = Risco::find($id);
        return view ('admin.risco.show', compact('data'));
    }

    public function edit(Risco $risco, $id)
    {
        $this->authorize('update', $risco);
        $data = Risco::find($id);
        $tipoRiscos = new CollectData($this->tipoRisco);
        $tipoRiscos = $tipoRiscos->collection('nome', 'ASC', true);
        return view(
            'admin.risco.edit', 
            compact('data', 'tipoRiscos')
        );
    }

    public function update(RiscoFormRequest $request, Risco $risco, $id)
    {
        $this->authorize('update', $risco);
        $dataForm = $request->validated();
        $alter = new CheckDataBase($risco);
        $alter = $alter->checkInDatabase(
            ['nome'], 
            [$dataForm['nome']], 
        );
        if($alter){
            $newRegister = new ChangeRegister($risco);
            $newRegister = $newRegister->changeRegisterInDatabase(
                $id,
                $alter
            );
            return SuccessRedirectMessage::successRedirect(
                'risco.index',
                ['success' => 'Risco alterado com sucesso'],
                $id
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'risco.edit',
                ['errors' => 'Risco já cadastrado'],
                $id
            );
        }
    }

    public function destroy(Risco $risco, $id)
    {
        $this->authorize('delete', $risco);
        $check = new CheckToDelete($risco);
        $check = $check->checkDb(
            $id,
            [$this->atendimentoRisco, $this->grupoRisco],
            ['risco_id']
        );
        if($check){
            return FailRedirectMessage::failRedirect(
                'risco.show',
                ['errors' => "Existe um registro vinculado a ". $check['table']],
                $id
            );
        } else {
            $delete = new DeleteRegister($risco);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'risco.index',
                ['success' => 'Risco apagado com sucesso'],
                ''
            );
        }
    }

    public function search(Request $request, Risco $risco)
    {    
        $dataForm = $request->validate([
            'nome' => 'required'
        ]);
        $nome = "%".$dataForm['nome']."%";
        $riscos = new SearchRequest($risco);
        $riscos = $riscos->searchIt('nome', [$nome]);
        return view('admin.risco.index' ,compact('riscos', 'nome', 'dataForm'));
    }
}
