<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\GrupoRisco;
use App\Models\Grupo;
use App\Models\Risco;

use App\Http\Requests\Admin\GrupoRiscoFormRequest;
use App\Classes\GrupoRisco\CollectData;
use App\Classes\GrupoRisco\SaveInDatabase;
use App\Classes\GrupoRisco\DeleteRegister;

class GrupoRiscoController extends Controller
{
    private $grupoRisco;

    public function __construct(
        GrupoRisco $grupoRisco,
        Grupo $grupo,
        Risco $risco
    ) {
        $this->grupoRisco = $grupoRisco;
        $this->grupo = $grupo;
        $this->risco = $risco;
    }

    public function index($id)
    {
        $grupo = $this->grupo->find($id);
        
        $riscos = new CollectData($this->risco);
        $riscos = $riscos->collection('nome', 'ASC');
        
        $grupoRiscos = $this->grupoRisco->where('grupo_id', $id)->get();

        return view(
            'admin.grupoRisco.index', 
            compact('grupo', 'riscos', 'grupoRiscos')
        );
    }

    public function store(GrupoRiscoFormRequest $request, $id)
    {
        $dataForm = $request->all();
        $risco_id = filter_var($dataForm['risco_id'], FILTER_SANITIZE_STRING);

        $grupoRisco = new SaveInDatabase($this->grupoRisco);
        $grupoRisco = $grupoRisco->saveDatabase(
            ['grupo_id', 'risco_id'], 
            [$id, $risco_id], 
            'gruporisco.index',
            ['success' => 'Registro cadastrado com sucesso'],
            'gruporisco.index',
            ['errors' => 'Registro ja cadastrado'],
            $id
        );

        return $grupoRisco;
    }

    public function destroy($id)
    {
        $deleted = new DeleteRegister($this->grupoRisco);
        $register = $this->grupoRisco->find($id);
        $grupo_id = $register->grupo->id;
        $deleted = $deleted->erase
        (
            $id,
            [],
            [],
            'gruporisco.index',
            'gruporisco.index',
            ['success' => 'Registro apagado com sucesso.'],
            $grupo_id
        );
       
        return $deleted;
    }
}
