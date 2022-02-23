<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Funcao;
use App\Models\Empregado;
use App\Models\Atendimento;
use App\Models\GrupoFuncao;

use App\Http\Requests\Admin\FuncaoFormRequest; 
use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\ChangeRegister;
use App\Classes\DeleteRegister;
use App\Classes\SearchRequest;

class FuncaoController extends Controller
{
    public function __construct(
        Funcao $funcao,
        Empregado $empregado,
        Atendimento $atendimento,
        GrupoFuncao $grupoFuncao
    ) {
        $this->funcao = $funcao;
        $this->empregado = $empregado;
        $this->atendimento = $atendimento;
        $this->grupoFuncao = $grupoFuncao;
    }
    
    public function index()
    {
        $funcoes = new CollectData($this->funcao);
        $data = $funcoes->collection('nome', 'ASC', false);
        
        return view ('admin.funcao.index', compact('data'));
    }
  
    public function create()
    {
        $data = $this->funcao;
        return view ('admin.funcao.create', compact('data'));
    }

    public function store(FuncaoFormRequest $request)
    {
        $dataForm = $request->validated();
        $nome = $dataForm['nome']; 
        
        $funcoes = new SaveInDatabase($this->funcao);
        $funcoes = $funcoes->saveDatabase(
            ['nome'], 
            [$nome], 
            'funcao.index', 
            ['success' => 'Registro cadastrado com sucesso'], 
            'funcao.create', 
            ['errors' => 'Funcao ja cadastrada'],
                ''
        );
        
        return $funcoes;
    }
    
    public function show($id)
    {
        $data = Funcao::find($id);
        return view ('admin.funcao.show', compact('data'));
    }

    
    public function edit($id)
    {
        $data = Funcao::find($id);
        return view ('admin.funcao.edit', compact('data'));
    }

    public function update(FuncaoFormRequest $request, $id)
    {
        $dataForm = $request->validated();
        $nome = $dataForm['nome'];

        $alter = new ChangeRegister($this->funcao);
        $alter = $alter->changeRegisterInDatabase(
            $id, 
            ['nome'], 
            [$nome], 
            'funcao.index',
            ['success' => 'Alteracao efetuada com sucesso'],
            'funcao.edit',
            ['errors' => 'Registro igual ao anterior']
        );

        return $alter;
    }

    public function destroy($id)
    {
        $delete = new DeleteRegister($this->funcao);
        $delete = $delete->erase(
            $id, 
            [$this->empregado, $this->atendimento, $this->grupoFuncao], 
            ['funcao_id'],
            'funcao.show',
            'funcao.index',
            ['success' => 'Função deletada com sucesso'],
            ''
        );
        
        return $delete;
    }

    public function search(Request $request)
    {
        $dataForm = $request->only('nome');
        $nome = '%'.$dataForm['nome'].'%';

        $funcoes = new SearchRequest($this->funcao);
        $data = $funcoes->searchIt('nome', ['nome' => $nome]);
    
        return view('admin.funcao.index', compact('nome', 'data'));
    }
}
