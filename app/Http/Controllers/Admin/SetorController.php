<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setor;
use App\Models\Atendimento;
use App\Models\Empregado;
use App\Http\Requests\Admin\SetorFormRequest;
use App\Classes\Setor\CollectData;
use App\Classes\Setor\SaveInDatabase;
use App\Classes\Setor\ChangeRegister;
use App\Classes\Setor\DeleteRegister;
use App\Classes\Setor\SearchRequest;

class SetorController extends Controller
{
    public function __construct(
        Setor $setor,
        Atendimento $atendimento,
        Empregado $empregado
    )
    {
        $this->setor = $setor;
        $this->atendimento = $atendimento;
        $this->empregado = $empregado;
    }

    public function index()
    {
        $setores = new CollectData($this->setor);
        $setores = $setores->collection('nome', 'ASC');
        
        return view ('admin.setor.index', compact('setores'));
    }
    
    public function create()
    {
        return view ('admin.setor.create');
    }

    public function store(SetorFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = filter_var($dataForm['nome'], FILTER_SANITIZE_STRING);
        
        $setores = new SaveInDatabase($this->setor);
        $setores = $setores->saveDatabase
        (
        ['nome'],
        [$nome],
        'setores.index',
        ['success' => 'Registro cadastrado com sucesso'], 
        'setores.create', 
        ['errors' => 'Setor ja cadastrado'],
        ''
            );
        return $setores;
    }


    public function show($id)
    {
        // buscar a funcao
        $setores = Setor::find($id);
        return view ('admin.setor.show', compact('setores'));
    }

    
    public function edit($id)
    {
        // buscar a funcao
        $setores = Setor::find($id);
        return view ('admin.setor.edit', compact('setores'));
    }

    
    public function update(SetorFormRequest $request, $id)
    {
        // pegar os dados do request
        $dataForm = $request->all();
        $nome = filter_var($dataForm['nome'], FILTER_SANITIZE_STRING);

        $alter = new ChangeRegister($this->setor);
        $alter = $alter->changeRegisterInDatabase
        (
        $id, 
        ['nome'], 
        [$nome], 
        'setores.index',
        ['success' => 'Alteracao efetuada com sucesso'],
        'setores.edit',
        ['errors' => 'Registro igual ao anterior']
        );

        return $alter;
    }

    
    public function destroy($id)
    {
        $delete = new DeleteRegister($this->setor);
        $delete = $delete->erase(
            $id, 
            [$this->empregado, $this->atendimento], 
            ['setor_id'],
            'setores.show',
            'setores.index',
            ['success' => 'Função deleteada com sucesso'],
            ''
        );
        
        return $delete;
    }

    public function search(Request $request){

        $dataForm = $request->all();
        $nome = filter_var('%'.$dataForm['nome'].'%', FILTER_SANITIZE_STRING);

        $setores = new SearchRequest($this->setor);

        $setores = $setores->searchIt('nome', ['nome' => $nome]);
    
        return view('admin.setor.index', ['dataForm'=>$dataForm, 'setores'=>$setores]);
    }
    
}
