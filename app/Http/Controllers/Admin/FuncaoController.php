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
        Empregado $empregado,
        Atendimento $atendimento,
        GrupoFuncao $grupoFuncao
    ) 
    {
        $this->empregado = $empregado;
        $this->atendimento = $atendimento;
        $this->grupoFuncao = $grupoFuncao; 
    }
    
    public function index(Funcao $funcao)
    {
        $this->authorize('view-any', $funcao);
        $funcoes = new CollectData($funcao);
        $data = $funcoes->collection('nome', 'ASC', false);
        return view ('admin.funcao.index', compact('data'));
    }
  
    public function create(Funcao $funcao)
    {
        $this->authorize('create', $funcao);
        $data = $funcao;
        return view ('admin.funcao.create', compact('data'));
    }

    public function store(FuncaoFormRequest $request, Funcao $funcao)
    {
        $this->authorize('create', $funcao);
        $dataForm = $request->validated();
        $data = new CheckDataBase($funcao);
        $data = $data->checkInDatabase(['nome'], [$dataForm['nome']]);
        if($data){
            $store = new SaveInDatabase($funcao);
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
    
    public function show(Funcao $funcao, $id)
    {
        $this->authorize('view', $funcao);
        $data = $funcao->find($id);
        return view ('admin.funcao.show', ['data' => $data]);
    }

    
    public function edit(Funcao $funcao, $id)
    {
        $this->authorize('update', $funcao);
        $data = Funcao::find($id);
        return view ('admin.funcao.edit', compact('data'));
    }

    public function update(FuncaoFormRequest $request, Funcao $funcao,  $id)
    {
        $dataForm = $request->validated();
        $alter = new CheckDatabase($funcao);
        $alter = $alter->checkInDatabase(
           ['nome'],
           [$dataForm['nome']]
        );

        if($alter){
            $newRegister = new ChangeRegister($funcao);
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

    public function destroy(Funcao $funcao, $id)
    {
        $check = new CheckToDelete($funcao);
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
            $delete = new DeleteRegister($funcao);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'funcao.index',
                ['success' => 'Função apagada com sucesso'],
                ''
            );
        }
    }

    public function search(Request $request, Funcao $funcao)
    {
        $dataForm = $request->validate([
            'nome' => 'required'
        ]);
        
        $nome = '%'.$dataForm['nome'].'%';
        $funcoes = new SearchRequest($funcao);
        $data = $funcoes->searchIt('nome', ['nome' => $nome]);
        
        return view('admin.funcao.index', compact('nome', 'data', 'dataForm'));
    }
}
