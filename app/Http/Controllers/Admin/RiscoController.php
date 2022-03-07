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
        Risco $risco,
        TipoRisco $tipoRisco,
        AtendimentoRisco $atendimentoRisco,
        GrupoRisco $grupoRisco
        
    )
    {
        $this->risco = $risco;
        $this->tipoRisco = $tipoRisco;
        $this->atendimentoRisco = $atendimentoRisco;
        $this->grupoRisco = $grupoRisco;
    }

    public function index()
    {
        $riscos = new CollectData($this->risco);
        $data = $riscos->collection('nome', 'ASC', false);
        return view ('admin.risco.index', compact('data'));
    }
   
    public function create()
    {
        $data = $this->risco;
        $tipoRiscos = new CollectData($this->tipoRisco);
        $tipoRiscos = $tipoRiscos->collection('nome', 'ASC', true);
        return view ('admin.risco.create', compact('tipoRiscos', 'data'));
    }
     
    public function store(RiscoFormRequest $request)
    {
        $dataForm = $request->validated();
        $data = new CheckDataBase($this->risco);
        $data = $data->checkInDatabase(
            ['nome'], 
            [$dataForm['nome']]);
        if($data){
            $store = new SaveInDatabase($this->risco);
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

    public function show($id)
    {
        $data = $this->risco->find($id);
        return view ('admin.risco.show', compact('data'));
    }

    public function edit($id)
    {
      $data = $this->risco->find($id);
      $tipoRiscos = new CollectData($this->tipoRisco);
      $tipoRiscos = $tipoRiscos->collection('nome', 'ASC', true);
      return view(
          'admin.risco.edit', 
          compact('data', 'tipoRiscos')
      );
    }

    public function update(RiscoFormRequest $request, $id)
    {
        $dataForm = $request->validated();
        $alter = new CheckDataBase($this->risco);
        $alter = $alter->checkInDatabase(
            ['nome'], 
            [$dataForm['nome']], 
        );
        if($alter){
            $newRegister = new ChangeRegister($this->risco);
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

    public function destroy($id)
    {
        $check = new CheckToDelete($this->risco);
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
            $delete = new DeleteRegister($this->risco);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'risco.index',
                ['success' => 'Risco apagado com sucesso'],
                ''
            );
        }
    }

    public function search(Request $request)
    {
        $dataForm = $request->validate([
            'nome' => 'required'
        ]);
        $nome = "%".$dataForm['nome']."%";
        $riscos = new SearchRequest($this->risco);
        $riscos = $riscos->searchIt('nome', [$nome]);
        return view('admin.risco.index' ,compact('riscos', 'nome', 'dataForm'));
    }
}
