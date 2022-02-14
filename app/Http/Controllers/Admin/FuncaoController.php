<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Funcao;
use App\Models\Empregado;
use App\Models\Atendimento;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\FuncaoFormRequest; 
use App\Classes\Funcao\CollectData;
use App\Classes\Funcao\SaveInDatabase;
use App\Classes\Funcao\ChangeRegister;
use App\Classes\Funcao\DeleteRegister;
use App\Classes\Funcao\SearchRequest;



class FuncaoController extends Controller
{
    public function __construct(
        Funcao $funcao,
        Empregado $empregado,
        Atendimento $atendimento
    )
    {
        $this->funcao = $funcao;
        $this->empregado = $empregado;
        $this->atendimento = $atendimento;
       
    }
    
    public function index()
    {
        $funcoes = new CollectData($this->funcao);
        $funcoes = $funcoes->collection('nome', 'ASC');
        
        return view ('admin.funcao.index', compact('funcoes'));
    }
  
    public function create()
    {
        return view ('admin.funcao.create');
    }

    public function store(FuncaoFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = filter_var($dataForm['nome'], FILTER_SANITIZE_STRING); 
        
        $funcoes = new SaveInDatabase($this->funcao);
        $funcoes = $funcoes->saveDatabase
        (
        ['nome'], 
        [$nome], 
        'funcoes.index', 
        ['success' => 'Registro cadastrado com sucesso'], 
        'funcoes.create', 
        ['errors' => 'Funcao ja cadastrada'],
            ''
        );
        
        return $funcoes;
    }
    
    public function show($id)
    {
        // buscar a funcao
        $funcao = Funcao::find($id);
        return view ('admin.funcao.show', compact('funcao'));
    }

    
    public function edit($id)
    {
        // buscar a funcao
        $funcao = Funcao::find($id);
        return view ('admin.funcao.edit', ['funcao'=>$funcao]);
    }

    
    public function update(FuncaoFormRequest $request, $id)
    {
        // pegar os dados do request
        $dataForm = $request->all();
        $nome = filter_var($dataForm['nome'], FILTER_SANITIZE_STRING);

        $alter = new ChangeRegister($this->funcao);
        $alter = $alter->changeRegisterInDatabase
        (
        $id, 
        ['nome'], 
        [$nome], 
        'funcoes.index',
        ['success' => 'Alteracao efetuada com sucesso'],
        'funcoes.edit',
        ['errors' => 'Registro igual ao anterior']
        );

        return $alter;
    }

    
    public function destroy($id)
    {
        // dd($id);
        $delete = new DeleteRegister($this->funcao);
        $delete = $delete->erase(
            $id, 
            [$this->empregado, $this->atendimento], 
            ['funcao_id'],
            'funcoes.show',
            'funcoes.index',
            ['success' => 'Função deleteada com sucesso'],
            ''
        );
        
        return $delete;
    }

    public function search(Request $request){

        $dataForm = $request->all();
        $nome = filter_var('%'.$dataForm['nome'].'%', FILTER_SANITIZE_STRING);

        $funcoes = new SearchRequest($this->funcao);

        $funcoes = $funcoes->searchIt('nome', ['nome' => $nome]);
    
        return view('admin.funcao.index', ['dataForm'=>$dataForm, 'funcoes'=>$funcoes]);
    }
}
