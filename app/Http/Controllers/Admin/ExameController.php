<?php

namespace App\Http\Controllers\Admin;

use App\AbstractClasses\CheckDataBase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Exame;
use App\Models\AtendimentoExame;
use App\Models\GrupoExame;

use App\Http\Requests\Admin\ExameFormRequest; 
use App\Classes\CollectData;
use App\Classes\SaveInDatabase;
use App\Classes\ChangeRegister;
use App\Classes\CheckToDelete;
use App\Classes\DeleteRegister;
use App\Classes\SearchRequest;
use App\Traits\FailRedirectMessage;
use App\Traits\SuccessRedirectMessage;

class ExameController extends Controller
{
    use SuccessRedirectMessage, FailRedirectMessage;

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

        $alter = new CheckDataBase($this->exame);
        $alter = $alter->checkInDatabase(
            ['nome'],
            [$dataForm['nome']]
        );
        if($alter){
            $newRegister = new ChangeRegister(($this->exame));
            $newRegister = $newRegister->changeRegisterInDatabase(
                $id,
                $alter
            );
            return SuccessRedirectMessage::successRedirect(
                'exame.index',
                ['success' => 'Exame alterado com sucesso'],
                $id
            );
        } else {
            return FailRedirectMessage::failRedirect(
                'exame.edit',
                ['errors' => 'Exame já cadastrado'],
                $id
            );
        }
    }

    public function destroy($id)
    {
        $check = new CheckToDelete($this->exame);
        $check = $check->checkDb(
            $id,
            [$this->grupoExame, $this->atendimentoExame],
            ['exame_id']
        );

        if($check){
            return FailRedirectMessage::failRedirect(
                'exame.show',
                ['errors' => "Existe um registro vinculado a ". $check['table']],
                $id
            );
        } else {
            $delete = new DeleteRegister($this->exame);
            $delete = $delete->erase($id);
            return SuccessRedirectMessage::successRedirect(
                'exame.index',
                ['success' => 'Exame apagado com sucesso'],
                ''
            );
        }
    }

    public function search(Request $request){

        $dataForm = $request->only('nome');
        $nome = '%'.$dataForm['nome'].'%';

        $exames = new SearchRequest($this->exame);
        $data = $exames->searchIt('nome', ['nome' => $nome]);

        return view('admin.exame.index',compact('nome', 'data'));
    }
}
