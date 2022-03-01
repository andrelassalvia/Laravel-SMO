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
        Grupo $grupo,
        Atendimento $atendimento,
        Empregado $empregado,
        GrupoExame $grupoExame,
        GrupoRisco $grupoRisco,
        GrupoFuncao $grupoFuncao
       
    ) {
        $this->grupo = $grupo;
        $this->atendimento = $atendimento;
        $this->empregado = $empregado;
        $this->grupoExame = $grupoExame;
        $this->grupoRisco = $grupoRisco;
        $this->grupoFuncao = $grupoFuncao;
    }
    
    public function index()
    {
        $grupos = new CollectData($this->grupo);
        $data = $grupos->collection('nome', 'ASC', false);
        
        return view ('admin.grupo.index', compact('data'));
    }
  
    public function create()
    {
        $data = $this->grupo;
        return view ('admin.grupo.create', compact('data'));
    }

    public function store(GrupoFormRequest $request)
    {
        $dataForm = $request->validated();
        $nome = $dataForm['nome']; 
        
        $grupos = new SaveInDatabase($this->grupo);
        $grupos = $grupos->saveDatabase(
            ['nome'], 
            [$nome], 
            'grupo.index', 
            ['success' => 'Registro cadastrado com sucesso'], 
            'grupo.create', 
            ['errors' => 'Grupo ja cadastrado'],
            ''
        );
        
        return $grupos;
    }
    
    public function show($id)
    {
        $data = Grupo::find($id);
        return view ('admin.grupo.show', compact('data'));
    }

    
    public function edit($id)
    {
        $data = Grupo::find($id);
        return view ('admin.grupo.edit', compact('data'));
    }

    public function update(GrupoFormRequest $request, $id)
    {
        $dataForm = $request->validated();

        $alter = new CheckDataBase($this->grupo);
        $alter = $alter->checkInDatabase(
            ['nome'], 
            [$dataForm['nome']], 
        );

        if($alter){
            $newRegister = new ChangeRegister($this->grupo);
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

    public function destroy($id)
    {
        $check = new CheckToDelete($this->grupo);
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
            $delete = new DeleteRegister($this->grupo);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'grupo.index',
                ['success' => 'Grupo apagado com sucesso'],
                ''
            );
        }
    }

    public function search(Request $request)
    {
        $dataForm = $request->only('nome');
        $nome = '%'.$dataForm['nome'].'%';

        $grupos = new SearchRequest($this->grupo);
        $data = $grupos->searchIt('nome', ['nome' => $nome]);
    
        return view('admin.grupo.index', compact('nome', 'data'));
    }
}
