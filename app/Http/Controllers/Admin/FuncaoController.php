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
use App\Classes\CheckDatabase;
use App\Classes\CheckToDelete;
use App\Classes\DeleteRegister;
use App\Classes\SearchRequest;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

class FuncaoController extends Controller
{
    use SuccessRedirectMessage, FailRedirectMessage;

    public function __construct(
        Funcao $funcao,
        Empregado $empregado,
        Atendimento $atendimento,
        GrupoFuncao $grupoFuncao
    ) 
    {
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
        $data = new CheckDataBase($this->funcao);
        $data = $data->checkInDatabase(['nome'], [$dataForm['nome']]);
        if($data){
            $store = new SaveInDatabase($this->funcao);
            $store = $store->saveDatabase($data);
            return SuccessRedirectMessage::successRedirect(
                'funcao.index',
                ['success' => 'Função cadastrada com sucesso'],
                ''
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'funcao.create',
                ['errors' => 'Função já cadastrada'],
                ''
            );
        }
    }
    
    public function show($id)
    {
        // dd($id);
        
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
        $alter = new CheckDatabase($this->funcao);
        $alter = $alter->checkInDatabase(
           ['nome'],
           [$dataForm['nome']]
        );

        if($alter){
            $newRegister = new ChangeRegister($this->funcao);
            $newRegister = $newRegister->changeRegisterInDatabase(
                $id,
                $alter
            );
            return SuccessRedirectMessage::successRedirect(
                'funcao.index',
                ['success' => 'Função alterada com sucesso'],
                $id
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'funcao.edit',
                ['errors' => 'Função já cadastrada'],
                $id
            );
        }
    }

    public function destroy($id)
    {
        $check = new CheckToDelete($this->funcao);
        $check = $check->checkDb(
            $id,
            [$this->empregado, $this->atendimento, $this->grupoFuncao],
            ['funcao_id']
        );

        if($check){
            return FailRedirectMessage::failRedirect(
                'funcao.show',
                ['errors' => "Existe um registro vinculado a ". $check['table']],
                $id
            );
        } else {
            $delete = new DeleteRegister($this->funcao);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'funcao.index',
                ['success' => 'Função apagada com sucesso'],
                ''
            );
        }
    }

    public function search(Request $request)
    {
        $dataForm = $request->validate([
            'nome' => 'required'
        ]);
        $nome = '%'.$dataForm['nome'].'%';
        $funcoes = new SearchRequest($this->funcao);
        $data = $funcoes->searchIt('nome', ['nome' => $nome]);
        
        return view('admin.funcao.index', compact('nome', 'data', 'dataForm'));
    }
}
