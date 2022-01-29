<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\FuncaoFormRequest; 
use App\Funcao\CollectData;
use App\Funcao\SaveInDatabase;
use App\Models\Funcao;
use App\Funcao\ChangeRegister;
use App\Funcao\DeleteRegister;
use App\Funcao\FindRegister;
use App\Funcao\SearchRequest;


class FuncaoController extends Controller
{
    // Construct method
    public function __construct(CollectData $collectData, Funcao $funcao, SaveInDatabase $saveInDatabase, ChangeRegister $changeRegister, DeleteRegister $deleteRegister, FindRegister $findRegister, SearchRequest $searchRequest ){
        $this->collectData = $collectData;
        $this->funcao = $funcao;
        $this->saveInDatabase = $saveInDatabase;
        $this->changeRegister = $changeRegister;
        $this->deleteRegister = $deleteRegister;
        $this->findRegister = $findRegister;
        $this->searchRequest = $searchRequest;

 
    }

    public function index()
    {
        $funcoes = $this->collectData->collection('nome', 'ASC');
        
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
        
        $funcao = $this->saveInDatabase->saveDatabase($nome, 'nome');
        return $funcao;
        
    }
    
    public function show($id)
    {
        // buscar a funcao
        $funcao = $this->findRegister->findId($id);
        return view ('admin.funcao.show', compact('funcao'));
    }

    
    public function edit($id)
    {
        // buscar a funcao
        $funcao = $this->findRegister->findId($id);
        return view ('admin.funcao.edit', ['funcao'=>$funcao]);
    }

    
    public function update(FuncaoFormRequest $request, $id)
    {
        // pegar os dados do request
        $dataForm = $request->all();
        $nome = $dataForm['nome'];

        $alter = $this->changeRegister->changeRegisterInDatabase($id, 'nome', $nome, $dataForm);
        return $alter;
    }

    
    public function destroy($id)
    {
        $delete =  $this->deleteRegister->deleteRegisterInDatabase($id);
        return $delete;
    }

    public function search(Request $request){

        $dataForm = $request->all();
        $nome = '%'.$dataForm['nome'].'%';

        $funcoes = $this->searchRequest->searchIt('nome', $nome);
    
        return view('admin.funcao.index', ['dataForm'=>$dataForm, 'funcoes'=>$funcoes]);
    }
}
