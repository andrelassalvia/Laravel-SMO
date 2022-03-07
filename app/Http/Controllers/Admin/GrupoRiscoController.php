<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\GrupoRisco;
use App\Models\Grupo;
use App\Models\Risco;

use App\Http\Requests\Admin\GrupoRiscoFormRequest;
use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\DeleteRegister;
use App\Classes\CheckToDelete;
use App\Classes\CheckDataBase;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

class GrupoRiscoController extends Controller
{
    use SuccessRedirectMessage, FailRedirectMessage;

    private $grupoRisco;

    public function __construct(
        GrupoRisco $grupoRisco,
        Grupo $grupo,
        Risco $risco
    ) 
    {
        $this->grupoRisco = $grupoRisco;
        $this->grupo = $grupo;
        $this->risco = $risco;
    }

    public function index($id)
    {
        $data = $this->grupo->find($id);
        $riscos = new CollectData($this->risco);
        $riscos = $riscos->collection('nome', 'ASC', true);
        $grupoRiscos = $this->grupoRisco->where('grupo_id', $id)->get();
        return view(
            'admin.grupoRisco.index', 
            compact('data', 'riscos', 'grupoRiscos')
        );
    }

    public function store(GrupoRiscoFormRequest $request, $id)
    {
        $dataForm = $request->validated();
        $data = new CheckDataBase($this->grupoRisco);
        $data = $data->checkInDatabase(
            ['grupo_id', 'risco_id'], 
            [$id, $dataForm['risco_id']]);
        if($data){
            $store = new SaveInDatabase($this->grupoRisco);
            $store = $store->saveDatabase($data);
            return SuccessRedirectMessage::successRedirect(
                'gruporisco.index',
                ['success' => 'Registro cadastrado com sucesso'],
                $id
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'gruporisco.index',
                ['errors' => 'Registro já cadastrado'],
                $id
            );
        }
    }

    public function destroy($id)
    {
        $register = $this->grupoRisco->find($id);
        $mainId = $register['grupo_id'];
        $check = new CheckToDelete($this->grupoRisco);
        $check = $check->checkDb(
            $id,
            [],
            []
        );
        if($check){
            return FailRedirectMessage::failRedirect(
                'gruporisco.index',
                ['errors' => "Existe um registro vinculado a ". $check['table']],
                $id
            );
        } else {
            $delete = new DeleteRegister($this->grupoRisco);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'gruporisco.index',
                ['success' => 'Registro apagado com sucesso'],
                $mainId
            );
        }
    }
}
