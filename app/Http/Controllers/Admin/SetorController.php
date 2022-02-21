<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setor;
use App\Models\Atendimento;
use App\Models\Empregado;
use App\Models\GrupoFuncao;

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
        Empregado $empregado,
        GrupoFuncao $grupoFuncao
    ) {
        $this->setor = $setor;
        $this->atendimento = $atendimento;
        $this->empregado = $empregado;
        $this->grupoFuncao = $grupoFuncao;
    }

    public function index()
    {
        $setores = new CollectData($this->setor);
        $data = $setores->collection('nome', 'ASC');
        
        return view ('admin.setor.index', compact('data'));
    }
    
    public function create()
    {
        $data = $this->setor;
        return view ('admin.setor.create', compact('data'));
    }

    public function store(SetorFormRequest $request)
    {
        $dataForm = $request->validated();
        $nome = $dataForm['nome'];
        
        $setores = new SaveInDatabase($this->setor);
        $setores = $setores->saveDatabase(
            ['nome'],
            [$nome],
            'setor.index',
            ['success' => 'Registro cadastrado com sucesso'], 
            'setor.create', 
            ['errors' => 'Setor ja cadastrado'],
            ''
        );
        return $setores;
    }

    public function show($id)
    {
        $data = Setor::find($id);
        return view ('admin.setor.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Setor::find($id);
        return view ('admin.setor.edit', compact('data'));
    }

    public function update(SetorFormRequest $request, $id)
    {
        $dataForm = $request->validated();
        $nome = $dataForm['nome'];

        $alter = new ChangeRegister($this->setor);
        $alter = $alter->changeRegisterInDatabase(
            $id, 
            ['nome'], 
            [$nome], 
            'setor.index',
            ['success' => 'Alteracao efetuada com sucesso'],
            'setor.edit',
            ['errors' => 'Registro igual ao anterior']
        );

        return $alter;
    }

    public function destroy($id)
    {
        $delete = new DeleteRegister($this->setor);
        $delete = $delete->erase(
            $id, 
            [$this->empregado, $this->atendimento, $this->grupoFuncao], 
            ['setor_id'],
            'setor.show',
            'setor.index',
            ['success' => 'Função deletada com sucesso'],
            ''
        );
        
        return $delete;
    }

    public function search(Request $request)
    {
        $dataForm = $request->only('nome');
        $nome = '%'.$dataForm['nome'].'%';

        $setores = new SearchRequest($this->setor);
        $data = $setores->searchIt('nome', ['nome' => $nome]);
    
        return view('admin.setor.index', compact('nome', 'data'));
    }
}
