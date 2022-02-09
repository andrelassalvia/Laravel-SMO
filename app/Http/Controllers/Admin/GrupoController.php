<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Atendimento;
use App\Models\Empregado;
use App\Models\GrupoExame;
use App\Models\GrupoRisco;
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
        GrupoRisco $grupoRisco
       
    )
    {
        $this->grupo = $grupo;
        $this->atendimento = $atendimento;
        $this->empregado = $empregado;
        $this->grupoExame = $grupoExame;
        $this->grupoRisco = $grupoRisco;
        
       
    }
    
    public function index()
    {
        $grupos = new CollectData($this->grupo);
        $grupos = $grupos->collection('nome', 'ASC');
        
        
        return view ('admin.grupo.index', compact('grupos'));
    }
  
    public function create()
    {
        return view ('admin.grupo.create');
    }

    public function store(GrupoFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = $dataForm['nome']; // array 
        
        $grupos = new SaveInDatabase($this->grupo);
        $grupos = $grupos->saveDatabase
        (
        'nome', 
        ['nome' => $nome], 
        'grupos.index', 
        ['success' => 'Registro cadastrado com sucesso'], 
        'grupos.create', 
        ['errors' => 'Grupo ja cadastrado']
        );
        
        return $grupos;
    }
    
    public function show($id)
    {
        // buscar a funcao
        $grupo = Grupo::find($id);
        return view ('admin.grupo.show', compact('grupo'));
    }

    
    public function edit($id)
    {
        
        // buscar a funcao
        $grupo = Grupo::find($id);
        
        return view ('admin.grupo.edit', ['grupo'=>$grupo]);
    }

    
    public function update(GrupoFormRequest $request, $id)
    {
        // pegar os dados do request
        $dataForm = $request->all();
        $nome = $dataForm['nome'];

        $alter = new ChangeRegister($this->grupo);
        $alter = $alter->changeRegisterInDatabase
        (
        $id, 
        'nome', 
        ['nome'=>$nome], 
        'grupos.index',
        ['success' => 'Alteracao efetuada com sucesso'],
        'grupos.edit',
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
                $this->grupoRisco
            ], 
            ['grupo_id'],
            'grupos.show',
            ['errors' => 'Existem tabelas vinculadas a este registro'],
            'grupos.index',
            ['success' => 'Exame deleteado com sucesso']
        );
        
        return $delete;
    }

    public function search(Request $request){

        $dataForm = $request->all();
        $nome = '%'.$dataForm['nome'].'%';

        $grupos = new SearchRequest($this->grupo);

        $grupos = $grupos->searchIt('nome', ['nome' => $nome]);
    
        return view('admin.grupo.index', ['dataForm'=>$dataForm, 'grupos'=>$grupos]);
    }
}
