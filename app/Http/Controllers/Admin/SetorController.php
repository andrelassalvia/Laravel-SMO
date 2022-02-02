<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SetorFormRequest;
use App\Classes\Setor\CollectData;
use App\Classes\Setor\SaveInDatabase;
use App\Models\Setor;

class SetorController extends Controller
{
    public function __construct(Setor $setor ){
        $this->setor = $setor;
 
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
        $nome = $dataForm['nome'];
        
        $setores = new SaveInDatabase($this->setor);
        $setores = $setores->saveDatabase
        (
        'nome',
        ['nome' => $nome],
        'setores.index',
        ['success' => 'Registro cadastrado com sucesso'], 
        'setores.create', 
        ['errors' => 'Setor ja cadastrado']
            );
        return $setores;
    }

    public function show($id)
    {
        $setor = $this->setor->get($id);
        return view ('admin.setor.show', compact('setor'));
    }

   
    public function edit($id)
    {
        $setor = $this->setor->get($id);
        return view ('admin.setor.edit', ['setor'=>$setor]);
    }

    
    public function update(SetorFormRequest $request, $id)
    {
        $dataForm = $request->all();
        $nome = $dataForm['nome'];

        $alter = $this->setor->changeRegister($id, $nome, $dataForm);
        return $alter;
    }

    
    public function destroy($id)
    {
        return $this->setor->erase($id);

    }

    public function search(Request $request){

        $dataForm = $request->all();
        $nome = '%'.$dataForm['nome'].'%';

        $setores = $this->setor->search('nome', 'like', $nome, 'ASC', 5);
    
        return view('admin.setor.index', ['dataForm'=>$dataForm, 'setores'=>$setores]);
    }
}
