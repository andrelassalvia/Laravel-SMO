<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\FuncaoFormRequest; 
use App\Models\Funcao;


class FuncaoController extends Controller
{
    // Construct method
    public function __construct(Funcao $funcao ){
        $this->funcao = $funcao;
 
    }

    public function index()
    {
        $funcoes = $this->funcao->collection();
        
        return view ('admin.funcao.index', compact('funcoes'));
    }
  
    public function create()
    {
        return view ('admin.funcao.create');
    }

    public function store(FuncaoFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = $dataForm['nome'];
        
        $funcao = $this->funcao->saveInDatabase($nome);
        return $funcao;
        
    }
    
    public function show($id)
    {
        // buscar a funcao
        $funcao = $this->funcao->get($id);
        return view ('admin.funcao.show', compact('funcao'));
    }

    
    public function edit($id)
    {
        // buscar a funcao
        $funcao = $this->funcao->get($id);
        return view ('admin.funcao.edit', ['funcao'=>$funcao]);
    }

    
    public function update(FuncaoFormRequest $request, $id)
    {
        // pegar os dados do request
        $dataForm = $request->all();
        $nome = $dataForm['nome'];

        $alter = $this->funcao->changeRegister($id, $nome, $dataForm);
        return $alter;
    }

    
    public function destroy($id)
    {
        return $this->funcao->erase($id);
    }

    public function search(Request $request){

        $dataForm = $request->all();
        $nome = '%'.$dataForm['nome'].'%';

        $funcoes = $this->funcao->search('nome', 'like', $nome, 'ASC', 5);
    
        return view('admin.funcao.index', ['dataForm'=>$dataForm, 'funcoes'=>$funcoes]);
    }
}
