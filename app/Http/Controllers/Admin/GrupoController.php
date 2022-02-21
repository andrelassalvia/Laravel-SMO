<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Grupo;
use App\Models\Atendimento;
use App\Models\Empregado;
use App\Models\GrupoExame;
use App\Models\GrupoRisco;
use App\Models\GrupoFuncao;

use App\Http\Requests\Admin\GrupoFormRequest; 
use App\Classes\Grupo\CollectData;
use App\Classes\Grupo\SaveInDatabase;
use App\Classes\Grupo\ChangeRegister;
use App\Classes\Grupo\DeleteRegister;
use App\Classes\Grupo\SearchRequest;

class GrupoController extends Controller
{
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
        $data = $grupos->collection('nome', 'ASC');
        
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
        $nome = $dataForm['nome'];

        $alter = new ChangeRegister($this->grupo);
        $alter = $alter->changeRegisterInDatabase(
            $id, 
            ['nome'], 
            [$nome], 
            'grupo.index',
            ['success' => 'Alteracao efetuada com sucesso'],
            'grupo.edit',
            ['errors' => 'Registro igual ao anterior']
        );

        return $alter;
    }

    public function destroy($id)
    {
        $delete = new DeleteRegister($this->grupo);
        $delete = $delete->erase(
            $id, 
            [
                $this->atendimento,
                $this->empregado, 
                $this->grupoExame,
                $this->grupoRisco,
                $this->grupoFuncao
            ], 
            ['grupo_id'],
            'grupo.show',
            'grupo.index',
            ['success' => 'Registro apagado com sucesso'],
            ''
        );
        
        return $delete;
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
