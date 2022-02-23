<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Exame;
use App\Models\AtendimentoExame;
use App\Models\GrupoExame;

use App\Http\Requests\Admin\ExameFormRequest; 
use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\ChangeRegister;
use App\Classes\DeleteRegister;
use App\Classes\SearchRequest;


class ExameController extends Controller
{
    public function __construct(
        Exame $exame,
        AtendimentoExame $atendimentoExame,
        GrupoExame $grupoExame
    ) {
        $this->exame = $exame;
        $this->atendimentoExame = $atendimentoExame;
        $this->grupoExame = $grupoExame;
    }
    
    public function index()
    {
        $exames = new CollectData($this->exame);
        $data = $exames->collection('nome', 'ASC', false);
                
        return view ('admin.exame.index', compact('data'));
    }
  
    public function create()
    {
        $data = $this->exame;
        
        return view ('admin.exame.create', compact('data'));
    }

    public function store(ExameFormRequest $request)
    {
        $dataForm = $request->validated();
        $nome = $dataForm['nome']; 
        
        $exames = new SaveInDatabase($this->exame);
        $exames = $exames->saveDatabase(
        ['nome'], 
        [$nome], 
        'exame.index', 
        ['success' => 'Registro cadastrado com sucesso'], 
        'exame.create', 
        ['errors' => 'Exame ja cadastrado'],
        ''
        );
        
        return $exames;
    }
    
    public function show($id)
    {
        $data = Exame::find($id);
        return view ('admin.exame.show', compact('data'));
    }
    
    public function edit($id)
    {
        $data = Exame::find($id);
        
        return view ('admin.exame.edit', compact('data'));
    }
    
    public function update(ExameFormRequest $request, $id)
    {
        $dataForm = $request->validated();
        $nome = $dataForm['nome'];

        $alter = new ChangeRegister($this->exame);
        $alter = $alter->changeRegisterInDatabase(
            $id, 
        ['nome'], 
        [$nome], 
        'exame.index',
        ['success' => 'Alteração efetuada com sucesso'],
        'exame.edit',
        ['errors' => 'Registro igual ao anterior']
        );

        return $alter;
    }

    public function destroy($id)
    {
        $delete = new DeleteRegister($this->exame);
        $delete = $delete->erase(
            $id, 
            [$this->grupoExame, $this->atendimentoExame], 
            ['exame_id'],
            'exame.show',
            'exame.index',
            ['success' => 'Exame deletado com sucesso'],
            ''
        );
        
        return $delete;
    }

    public function search(Request $request){

        $dataForm = $request->only('nome');
        $nome = '%'.$dataForm['nome'].'%';

        $exames = new SearchRequest($this->exame);
        $data = $exames->searchIt('nome', ['nome' => $nome]);

        return view('admin.exame.index',compact('nome', 'data'));
    }
}
