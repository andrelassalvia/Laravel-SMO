<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GrupoRiscoFormRequest;
use Illuminate\Http\Request;
use App\Models\GrupoRisco;
use App\Models\Grupo;
use App\Models\Risco;
use App\Classes\GrupoRisco\CollectData;
use App\Classes\GrupoRisco\SaveInDatabase;




class GrupoRiscoController extends Controller
{

    private $grupoRisco;

    public function __construct
    (
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
        
        $grupo = $this->grupo->find($id);
        
        $riscos = new CollectData($this->risco);
        $riscos = $riscos->collection('nome', 'ASC');
        
        
        $grupoRiscos = $this->grupoRisco->where('grupo_id', $id)->get();
        
      

        return view('admin.grupoRisco.index', 
        [
            'grupo' => $grupo,
            'riscos' => $riscos,
            'grupoRiscos' => $grupoRiscos
        ]
    );
    }

    public function store(GrupoRiscoFormRequest $request, $id)
    {
        
        $dataForm = $request->all();
        
        $risco_id = $dataForm['risco_id'];

        $grupoRisco = new SaveInDatabase($this->grupoRisco);
        $grupoRisco = $grupoRisco->saveDatabase
        (
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
        $register = $this->grupoRisco->find($id);
        $grupo_id = $register->grupo_id;
        $deleted = $register->delete();
       
        if($deleted){

            return redirect()->route('gruporisco.index', $grupo_id)->with(['success' => 'Registro apagado com sucesso.'])->withInput();
        }else{

            return redirect()->route('gruporisco.index', $grupo_id)->withErrors(['errors' => 'Falha no delete'])->withInput();
        }

    }
    
}
