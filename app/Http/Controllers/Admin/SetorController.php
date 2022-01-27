<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SetorFormRequest;
use App\Models\Setor;

class SetorController extends Controller
{
    public function __construct(Setor $setor ){
        $this->setor = $setor;
 
    }
    public function index()
    {
        $setores = $this->setor->collection();
        
        return view ('admin.setor.index', compact('setores'));
    }

    
    public function create()
    {
        return view ('admin.funcao.create');
    }

    
    
    public function store(SetorFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        
        $setor = $this->setor->saveInDatabase($nome);
        return $setor;
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
