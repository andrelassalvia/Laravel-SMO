<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Exame;
use App\Models\AtendimentoExame;
use App\Models\GrupoExame;

use App\Http\Requests\Admin\ExameFormRequest; 
use App\Classes\Exame\CollectData;
use App\Classes\Exame\SaveInDatabase;
use App\Classes\Exame\ChangeRegister;
use App\Classes\Exame\DeleteRegister;
use App\Classes\Exame\SearchRequest;


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
        $exames = $exames->collection('nome', 'ASC');
        
        return view ('admin.exame.index', compact('exames'));
    }
  
    public function create()
    {
        return view ('admin.exame.create');
    }

    public function store(ExameFormRequest $request)
    {
        $dataForm = $request->all();
        $nome = filter_var($dataForm['nome'], FILTER_SANITIZE_STRING); 
        
        $exames = new SaveInDatabase($this->exame);
        $exames = $exames->saveDatabase(
        ['nome'], 
        [$nome], 
        'exames.index', 
        ['success' => 'Registro cadastrado com sucesso'], 
        'exames.create', 
        ['errors' => 'Exame ja cadastrado'],
        ''
        );
        
        return $exames;
    }
    
    public function show($id)
    {
        $exame = Exame::find($id);
        return view ('admin.exame.show', compact('exame'));
    }
    
    public function edit($id)
    {
        $exame = Exame::find($id);
        return view ('admin.exame.edit', compact('exame'));
    }
    
    public function update(ExameFormRequest $request, $id)
    {
        $dataForm = $request->all();
        $nome = filter_var($dataForm['nome'], FILTER_SANITIZE_STRING);

        $alter = new ChangeRegister($this->exame);
        $alter = $alter->changeRegisterInDatabase(
            $id, 
        ['nome'], 
        [$nome], 
        'exames.index',
        ['success' => 'Alteração efetuada com sucesso'],
        'exames.edit',
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
            'exames.show',
            'exames.index',
            ['success' => 'Exame deleteado com sucesso'],
            ''
        );
        
        return $delete;
    }

    public function search(Request $request){

        $dataForm = $request->all();
        $nome = filter_var('%'.$dataForm['nome'].'%', FILTER_SANITIZE_STRING);

        $exames = new SearchRequest($this->exame);
        $exames = $exames->searchIt('nome', ['nome' => $nome]);

        return view('admin.exame.index',compact('nome', 'exames'));
    }
}
